(function($) {
	$.extend($.fx.step,{
	    backgroundPosition: function(fx) {
            if (fx.state === 0 && typeof fx.end == 'string') {
                var start = $.curCSS(fx.elem, 'backgroundPosition');
                start = toArray(start);
                fx.start = [start[0],start[2]];
                var end = toArray(fx.end);
                fx.end = [end[0],end[2]];
                fx.unit = [end[1],end[3]];
			}
            var nowPosX = [];
            nowPosX[0] = ((fx.end[0] - fx.start[0]) * fx.pos) + fx.start[0] + fx.unit[0];
            nowPosX[1] = ((fx.end[1] - fx.start[1]) * fx.pos) + fx.start[1] + fx.unit[1];
            fx.elem.style.backgroundPosition = nowPosX[0]+' '+nowPosX[1];

           function toArray(strg){
               strg = strg.replace(/left|top/g,'0px');
               strg = strg.replace(/right|bottom/g,'100%');
               strg = strg.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2");
               var res = strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);
               return [parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]];
           }
        }
	});
})(jQuery);

$(document).ready(function() {
						   
	$('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
		var input = $(this);
		if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		}
	}).blur().parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
			}
		})
	});

	var tabpanel = $('#tab > ul.tabContan');
		tabpanel.hide().filter(':first').show();
	
		$('#tab .tabNav a').click(function(){
		tabpanel.hide();
		var thisConte ="#"+ $(this).attr('title');
	
		tabpanel.filter(thisConte).show();
	
		$('#tab .tabNav li').removeClass('active');
		$(this).parent("li").addClass('active');
	
		return false;
	})
	
	$('.tabContan li:nth-child(odd), .tweetLeft li:nth-child(odd), .cartoonLeft li:nth-child(even)').addClass('ml0');
	
	loadMore();
	initComments();
	loadForms();
	disableHash();
	
	$('a.firstLoad').trigger('click');
	
	$('a.pollBut.ajaxButton').hover(function() {
		$(this).find('span.radioBut').addClass('checked');
	}, function(){
		$(this).find('span.radioBut').removeClass('checked');
	});
	
	$(document).click(function(e) {
		var t = (e.target);
		if(t != $(".notbox").get(0)) {
			$(".notbox").removeClass('notboxshow');
			$(".notbox").parent('.notification').find('a.active').removeClass('active');
		}
	});
	
	$('ul.accoNav li .accoContan').hide();
	$('ul.accoNav li .accoContan:first').show();
	
	$('.accoNav li a.prline').click(function() {
	  	var checkElement = $(this).next();
	  	if((checkElement.is('.accoContan')) && (checkElement.is(':visible'))) {
	   		return false;
		}
	  	if((checkElement.is('.accoContan')) && (!checkElement.is(':visible'))) {
			$('ul.accoNav li .accoContan:visible').slideUp('normal');
			checkElement.slideDown('normal');
			$("ul.accoNav li a").removeClass("active");
			$(this).addClass("active");		
			return false;
		}
		
	});

});

function YouTubeGetID(url){
  var ID = '';
  url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
  if(url[2] !== undefined) {
    ID = url[2].split(/[^0-9a-z_]/i);
    ID = ID[0];
  }
  else {
    ID = url;
  }
  return ID;
}

function loadMore() {
	$('a.ajaxButton').each(function() {
		$(this).click(function(e) {
			e.stopImmediatePropagation(); //alert($(e.currentTarget).html());
			var $this = $(e.currentTarget); //alert($this.parent().attr('data-popup'));
			
			if($this.attr('data-popup')) {
				togglePopupBox($this.attr('data-popup'));
			}
			
			if($this.attr('data-url')) {
				var urlData = $this.attr('data-url').split('?'); 
				var resEle = $this.attr('data-container');
				var act = $this.attr('data-action');
				var trig = $this.attr('data-trigger');

				/** For data inputs */
				var qs = (urlData[1]) ? urlData[1]+'&' : '';
				if($this.attr('data-inputs')) {
					var inputs = $this.attr('data-inputs').split(',');
					var query_string = new Array();
					for(i=0;i<inputs.length;i++) {
						var element = inputs[i];
						query_string[i] = element+'='+$('#'+element).val();
					}
					qs += query_string.join('&'); //alert(qs);
				}
				
				if($this.attr('data-class')) {
					var $class = $this.attr('data-class');
					$this.addClass($class);
				}

				if(act == 'delete' && $this.attr('data-msg')) {
					var conf = confirm($this.attr('data-msg'));
					if(!conf) return false;
				}
				
				$.ajax({  
					type: "POST",  
					url: SITE_URL+urlData[0],  
					data: qs,
					beforeSend: function() {
						if($this.hasClass('loadMore')) {
							$this.html('').addClass('loading');//Loading image during the Ajax Request
						}
						
						if($this.hasClass('pollBut')) {
							$this.addClass('append-loading');//Loading image during the Ajax Request
							$this.find('span.radioBut').addClass('selected');
						}
					},
					success: function(responseText) { //alert($this.hasClass('loadMore'));
						if(!resEle) {
							return true;
						}
						
						if(trig) {
							$(trig).click();
							return true;
						} else if(act == 'delete') {
                            $(resEle).html(responseText);
                            $(resEle).fadeOut(3000, function() { $(this).remove(); });
                        }
					
						if($this.hasClass('loadMore')) {
							if(act == 'append') $(resEle).append(responseText);
						 	else $(resEle).html(responseText);
							
							$('.loading').parents('li').remove();
						} else if($this.hasClass('pollBut')) {
							if(responseText == '900') {
								$this.parent().append('You have already posted your vote');
								$this.removeAttr('data-url');
							} else {
								addPollResults(responseText);
							}
						} else {
							if(act == 'append') $(resEle).append(responseText);
						 	else $(resEle).html(responseText);
						}
						
						if(!$this.hasClass('_type')) {
							$this.removeAttr('data-url');
							$this.removeAttr('data-container');
							$this.removeAttr('data-class');
							$this.removeAttr('data-action');
						}
						
						loadMore();
						loadForms();
						initComments();
						disableHash();
						
						if($this.attr('data-lib')) {
							var lib = $this.attr('data-lib');
							
							if(lib == 'dataTable') loadDataTable();
						}
						
						if ( jQuery.isFunction(window.limiter) ) {
							var elem = $("#chars");
							$("#title").limiter(140,elem);
						}
					}  
				});
				$this.attr('disabled', 'disabled');
			}
			return false;
		});
	});
}


function fnFormatDetails ( oTable, nTr ) {
	var aData = oTable.fnGetData( nTr );
	var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
	sOut += '<tr><td>Rendering engine:</td><td>'+aData[1]+' '+aData[4]+'</td></tr>';
	sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
	sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
	sOut += '</table>';
	
	return sOut;
}


function loadDataTable() {
	$.getScript(THEME_URL+'assets/advanced-datatable/js/jquery.dataTables.js', function() {
		/*
           * Insert a 'details' column to the table
        */
        var nCloneTh = document.createElement( 'th' );
        var nCloneTd = document.createElement( 'td' );
        nCloneTd.innerHTML = '<img src="'+THEME_URL+'assets/advanced-datatable/images/details_open.png">';
        nCloneTd.className = "center";

        $('#hidden-table-info thead tr').each( function () {
            this.insertBefore( nCloneTh, this.childNodes[0] );
        } );

        $('#hidden-table-info tbody tr').each( function () {
            this.insertBefore(  nCloneTd.cloneNode( true ), this.childNodes[0] );
        });

        /*
         * Initialse DataTables, with no sorting on the 'details' column
         */
       var hTable = $('#hidden-table-info').dataTable( {
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 0 ] }
            ],
            "aaSorting": [[0, 'asc']],
            "bJQueryUI": true,
			"aLengthMenu": [[100, 200, 300, -1],[100, 200, 300, "All"]],
			"iDisplayLength" : 100
        });

		/* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#hidden-table-info tbody td img').click(function () {
            var nTr = $(this).parents('tr')[0];
            if ( hTable.fnIsOpen(nTr) )
            {
                /* This row is already open - close it */
                this.src = THEME_URL+"assets/advanced-datatable/images/details_open.png";
                hTable.fnClose( nTr );
            }
            else
            {
                /* Open this row */
                this.src = THEME_URL+"assets/advanced-datatable/images/details_close.png";
                hTable.fnOpen( nTr, fnFormatDetails(hTable, nTr), 'details' );
            }
        });
		
		/*
         * Initialse DataTables, with no sorting on the 'details' column
         */
       var oTable = $('#table-info').dataTable( {
            "aoColumnDefs": [
                { "bSortable": true, "aTargets": [ 0 ] }
            ],
            "aaSorting": [[0, 'asc']],
			"aLengthMenu": [[100, 200, 300, -1],[100, 200, 300, "All"]],
			"iDisplayLength" : 100
        });
		
		/* Drag and Drop Ordering for only in Puzzle module
		  added on 25-Jun-2014 */
		if(moduleName=='puzzle') {
			oTable.rowReordering();
		} 
		
		/* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#table-info tbody td img').click(function () {
            var nTr = $(this).parents('tr')[0];
            if ( oTable.fnIsOpen(nTr) )
            {
                /* This row is already open - close it */
                this.src = THEME_URL+"assets/advanced-datatable/images/details_open.png";
                oTable.fnClose( nTr );
            }
            else
            {
                /* Open this row */
                this.src = THEME_URL+"assets/advanced-datatable/images/details_close.png";
                oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
            }
        });
	});
}

function loadForms() {
	$('form.ajaxForm').each(function() {
		$(this).submit(function(e) {
			e.stopImmediatePropagation(); //alert($(e.currentTarget).html());
			var $this = $(e.currentTarget); //alert($this.attr('action'));
			
			var urlData = $this.attr('action'); 
			var resEle = $this.attr('data-container');
			var act = $this.attr('data-action');
			var format = $this.attr('data-format');
			
			if($this.attr('data-class')) {
				var $class = $this.attr('data-class');
				$this.addClass($class);
			}
			
			var loading = '<li class="loading"></div>';
			
			$.ajax({  
				type: "POST",  
				url: SITE_URL+urlData,  
				data: $this.serialize(),
				beforeSend: function() {
					if($this.attr('data-loading') == 'true') {
						if(act == 'append') $(resEle).append(loading);
						else if(act == 'prepend') $(resEle).prepend(loading);
						else $(resEle).html(loading);
					}
				},
				success: function(responseText) { //alert($this.hasClass('loadMore'));
					if(responseText) {
						
						if(format == 'json') responseText = '<li>'+parseResponse(responseText)+'</li>';
						
						if(act == 'append') $(resEle).append(responseText);
						else if(act == 'prepend') $(resEle).prepend(responseText);
						else $(resEle).html(responseText);
					}
					e.currentTarget.reset();
					
					if($this.attr('data-reset')) {
						var ele = $this.attr('data-reset');
						$(ele).find('div.ar').remove();
						$(ele).find('a._clicked').removeClass('_clicked').removeClass('_hash').addClass('_up');
						clickButton();
					}
					disableHash();
				}  
			});
			
			e.preventDefault();
		});
	});
}

function parseResponse(text) {
	var jdata = jQuery.parseJSON(text); alert(jdata);
	
	var tpl = $('<li><a href="#" class="teamPeple"><img src="images/team-photo.png" alt="" width="40" /></a><a href="#" class="teamPeple"><span class="name"></span></a><br /><span class="chatnoicon"></span><span class="datetimetxt"></a></li>');
	
	tpl.find('a.teamPeple').attr('href', jdata.profileUrl);
	tpl.find('span.name').html(jdata.name);
	tpl.find('span.chatnoicon').html(jdata.message);
	tpl.find('img').attr('src', jdata.imgurl);
	tpl.find('span.datetimetxt').attr('data-livestamp', jdata.timestamp);
	
	$('#message_form').attr('data-action', 'append');
	
	return tpl.html();
}

function togglePopupBox(ele, e) {
	$('.notbox.notboxshow').removeClass('notboxshow');
	$(ele).toggleClass('notboxshow');
}

function addPollResults(json) {
	var jdata = jQuery.parseJSON(json);
	var total_votes = 0;
	$.each(jdata, function() {
		total_votes += parseInt(this['votes']);
	});
	
	$.each(jdata, function() {
		var optionID = this['optionID'];
		var votes = parseInt(this['votes']);
		var percent = Math.round((votes*100)/total_votes);
		var ele = $('#pollCount'+optionID);
		var drift = Math.round((percent * 272)/100);
		var lt = 272-drift;
		ele.append('<span style="margin-left:10px;">('+percent+'%)</span>');
		ele.stop().animate({
			backgroundPosition:"(-"+lt+"px 3px)"
		}, 500);
		$('#displayCount'+optionID).html(votes);
		ele.parents('.pollBox').find('.usersVoted span').html(total_votes);
		ele.parents('.agreeIn').find('.pollBut').removeAttr('data-url').removeAttr('data-container').removeAttr('data-action').removeClass('ajaxButton').unbind('hover');
	});

}

function initComments() {
	$(".msgInput").keypress(function(event) {
		if (event.which == 13) {
			event.stopImmediatePropagation();
			var form = $(this).parents("form");
			form.submit();
			return false;
		}
	});
}

function disableHash() {
	$('._hash').each(function() {
		$(this).click(function(e) {
			e.preventDefault();
			return false;
		});
	});
}