<?php
	define('FIRST_TEXT', 'First');
	define('PREVIOUS_TEXT', 'Previous');
	define('NEXT_TEXT', 'Next');
	define('LAST_TEXT', 'Last');
	
	define('FIRST_ARROW', '&laquo;');
	define('PREVIOUS_ARROW', '&lsaquo;');
	define('NEXT_ARROW', '&rsaquo;');
	define('LAST_ARROW', '&raquo;');
	
	define('FIRST1', "&nbsp; &laquo; ##FIRST## &nbsp;");
	define('FIRST2', "&nbsp; <a href='##SELF####SEP####NO_FIRST##'>&laquo; ##FIRST##</a> &nbsp;");
	define('PREV1', "&nbsp; &laquo; ##PREV## &nbsp;");
	define('PREV2', "&nbsp; <a href='##SELF####SEP####NO_PREV##'>&laquo; ##PREV##</a> &nbsp;");
	define('NEXT1', "&nbsp; ##NEXT## &raquo; &nbsp;");
	define('NEXT2', "&nbsp; <a href='##SELF####SEP####NO_NEXT##'>##NEXT## &raquo;</a> &nbsp;");
	define('LAST1', "&nbsp; ##LAST## &raquo; &nbsp;");
	define('LAST2', "&nbsp; <a href='##SELF####SEP####NO_LAST##'>##LAST## &raquo;</a> &nbsp;");
	define('TOTAL_RECORDS', " | Total Records: <strong>##TOTAL##</strong>");
	
	define('ACTUAL_PAGE', "Page <b>##PAGE##</b> of <b>##TOTAL_PAGES##</b>");

	define('PAGE_LIST', '&nbsp;<a href="##SELF####SEP####CURRENT_LINK##"##CURRENT_CLASS##>##CURRENT_PAGE##</a>&nbsp;');
	
	define('PAGE_OPTION', '&nbsp;<option value="##CURRENT_PAGE##">##CURRENT_PAGE##&nbsp;</option>&nbsp;');
	define('CURRENT_PAGE_OPTION', '&nbsp;<option value="##CURRENT_PAGE##" ##SELECTED##>##CURRENT_PAGE##&nbsp;</option>&nbsp;');
	define('PAGE_JUMP', 'Jump to the page ##PAGE_LIST##');
	
	define('HIDDEN_VAR', '<input type="hidden" name="##H_NAME##" value="##H_VAL##" />');
	
	define('PAGE_FORM', '<form name="jump_form" action="##ACTION##" method="get">##HIDDEN## ##PAGING##</form>');
?>