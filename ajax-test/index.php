<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test AJAX</title>
  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

    <script>
    function functionBeforeSend() {
      $("#info").text ("Ждём епта!");
      $("#load").css("cursor", "wait");
    }
    function functionSuccess(data) {
      $("#info").text (data);
      $("#load").css("cursor", "default");
    }
    $(document).ready (function () {
      $("#load").bind("click", function() {
        $.ajax({
          url:"content.php",
          type: "POST",
          data: ({name:"admin"}),
          dataType: "html",
          beforeSend: functionBeforeSend,
          success: functionSuccess
        }) 
      });
    });
  </script>
</head>
<body>
  Hi there!
  <p id="load" style="cursor:pointer;">Абзац подгрузочный</p>
  <div id="info"></div>


</body>
</html>