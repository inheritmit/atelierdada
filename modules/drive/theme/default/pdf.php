<?php
	if(!isset($req['slug']) || empty($req['slug'])) {
		_error('404');
		exit;
	}
	
	$filedata = $drvObj->getItemByTime($req['slug']);
		
	$upload_path = $module_upload_path."/".$filedata['userId']."/";
	$convert_path = $upload_path."/converted/";
	if($filedata['folder'] != 0) {
		$upload_path .= $filedata['folderStorageName'].'/';
	}
	
	$filepath = $upload_path.$filedata['storageName'];
	$ext = pathinfo($filepath, PATHINFO_EXTENSION);
	
	if(in_array($ext, array_keys($convertTypes))) {
		$outputFileName = str_replace('.'.$ext, '.pdf', $filedata['storageName']);
		$filepath = $convert_path.$outputFileName;
	}
	
	$data = file_get_contents($filepath);
?>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/pdfjs/build/pdf.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/pdfjs/textlayerbuilder.js"></script>
<script type="text/javascript">
window.onload = function () {
    var pdfBase64 = "<?php _e(base64_encode($data));?>"; //base64 representing the PDF

    var scale = 1.5; //Set this to whatever you want. This is basically the "zoom" factor for the PDF.

    /**
     * Converts a base64 string into a Uint8Array
     */
    function base64ToUint8Array(base64) {
        var raw = atob(base64); //This is a native function that decodes a base64-encoded string.
        var uint8Array = new Uint8Array(new ArrayBuffer(raw.length));
        for (var i = 0; i < raw.length; i++) {
            uint8Array[i] = raw.charCodeAt(i);
        }

        return uint8Array;
    }

    function loadPdf(pdfData) {
        PDFJS.disableWorker = true; //Not using web workers. Not disabling results in an error. This line is
        //missing in the example code for rendering a pdf.

        var pdf = PDFJS.getDocument(pdfData);
        pdf.then(renderPdf);
    }

    function renderPdf(pdf) {
        pdf.getPage(1).then(renderPage);
    }

    function renderPage(page) {
        var viewport = page.getViewport(scale);
        var $canvas = jQuery("<canvas></canvas>");

        //Set the canvas height and width to the height and width of the viewport
        var canvas = $canvas.get(0);
        var context = canvas.getContext("2d");
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        //Append the canvas to the pdf container div
        var $pdfContainer = jQuery("#pdfContainer");
        $pdfContainer.css("height", canvas.height + "px").css("width", canvas.width + "px");
        $pdfContainer.append($canvas);

        //The following few lines of code set up scaling on the context if we are on a HiDPI display
        var outputScale = getOutputScale();
        if (outputScale.scaled) {
            var cssScale = 'scale(' + (1 / outputScale.sx) + ', ' +
                (1 / outputScale.sy) + ')';
            CustomStyle.setProp('transform', canvas, cssScale);
            CustomStyle.setProp('transformOrigin', canvas, '0% 0%');

            if ($textLayerDiv.get(0)) {
                CustomStyle.setProp('transform', $textLayerDiv.get(0), cssScale);
                CustomStyle.setProp('transformOrigin', $textLayerDiv.get(0), '0% 0%');
            }
        }

        context._scaleX = outputScale.sx;
        context._scaleY = outputScale.sy;
        if (outputScale.scaled) {
            context.scale(outputScale.sx, outputScale.sy);
        }

        var canvasOffset = $canvas.offset();
        var $textLayerDiv = jQuery("<div />")
            .addClass("textLayer")
            .css("height", viewport.height + "px")
            .css("width", viewport.width + "px")
            .offset({
                top: canvasOffset.top,
                left: canvasOffset.left
            });

        $pdfContainer.append($textLayerDiv);

        page.getTextContent().then(function (textContent) {
            var textLayer = new TextLayerBuilder($textLayerDiv.get(0), 0); //The second zero is an index identifying
            //the page. It is set to page.number - 1.
            textLayer.setTextContent(textContent);

            var renderContext = {
                canvasContext: context,
                viewport: viewport,
                textLayer: textLayer
            };

            page.render(renderContext);
        });
    }

    var pdfData = base64ToUint8Array(pdfBase64);
    loadPdf(pdfData);
};
</script>
<div id="pdfContainer" class = "pdf-content"></div>