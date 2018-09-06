# upload_screenshot
Simple example how to upload screenshots from clipboard to remote server.

Open the page, make screenshot (alt+prtscn, cmd+shift+5, or different way), click to browser and paste clipboard (ctrl+v, cmd+v, etc).
You will see an alert box with filename on the remote server.
Change define('UPLOAD_DIR', '/tmp/dialogscreenshot/') and $.ajax({url: 'http://localhost/upload_screenshot.php',... to your variables.
