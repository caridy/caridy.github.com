<?php
if (array_key_exists('uri', $_GET) && file_exists($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'])) {
  $filename = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
  $fd = @fopen ($filename, "r");
  $content = @fread ($fd, filesize ($filename));
  @fclose ($fd);
  $content = str_replace('</body>', '<script type="text/javascript" src="http://www.google-analytics.com/urchin.js"></script><script type="text/javascript">_uacct="UA-2337646-1";if(typeof urchinTracker=="function")urchinTracker();</script></body>', $content);
} else {
  $content = '<p>The requested file do not exist, <a href="/sandbox/bubbling/index.html">click here to see the list of the available examples</a>...';
}
// get contents of a file into a string
echo ($content);
?>