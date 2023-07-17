
  document.getElementById('qrInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.onload = function(event) {
      var image = document.createElement('img');
      image.src = event.target.result;

      var zxing = window.ZXing;
      var codeReader = new zxing.BrowserQRCodeReader();

      codeReader.decodeFromImage(image)
        .then(function(result) {
          var scannedData = result.text;
          // You can now save the scanned data to your form or perform any other desired action
          console.log("Scanned Data: ", scannedData);
        })
        .catch(function(error) {
          console.error("Error scanning QR code: ", error);
        });
    };

    reader.readAsDataURL(file);
  });

