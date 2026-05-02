<!doctype html>
<html>
<head>
  <title>Fabric Preview</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

  <style>
    body{
      margin:0;
      overflow:hidden;
      background:black;
    }

    canvas{
      width:100vw;
      height:100vh;
      display:block;
    }
  </style>
</head>

<body>

<canvas id="canvas" width="1920" height="1080"></canvas>

<script>

const canvas = new fabric.Canvas('canvas',{

  selection:false
});

const json = localStorage.getItem('fabric_design');

if(json){

  canvas.loadFromJSON(json, () => {

    canvas.renderAll();

    canvas.getObjects().forEach(obj => {

      // =========================
      // VIDEO
      // =========================

      if(obj.customType === 'video'){

        const video = document.createElement('video');

        video.src = obj.videoSrc;

        video.loop = true;
        video.muted = true;
        video.playsInline = true;

        video.onloadeddata = () => {

          const fabricVideo =
            new fabric.Image(video,{

            left:obj.left,
            top:obj.top,

            scaleX:obj.scaleX,
            scaleY:obj.scaleY,

            angle:obj.angle,

            originX:obj.originX,
            originY:obj.originY,

            selectable:false,
            evented:false
          });

          canvas.remove(obj);

          canvas.add(fabricVideo);

          canvas.sendToBack(fabricVideo);

          video.play();
        };
      }

      // =========================
      // NETFLIX
      // =========================

      if(obj.customType === 'netflix'){

        obj.selectable = false;

        obj.on('mousedown', function(){

          window.location.href = "nflx://";

          setTimeout(() => {

            window.location.href =
              "https://www.netflix.com";

          },1000);
        });
      }

      // =========================
      // YOUTUBE
      // =========================

      if(obj.customType === 'youtube'){

        obj.selectable = false;

        obj.on('mousedown', function(){

          window.location.href =
            "vnd.youtube://";

          setTimeout(() => {

            window.location.href =
              "https://youtube.com";

          },1000);
        });
      }

    });

  });
}

// ======================================
// RENDER LOOP
// ======================================

(function animate(){

  canvas.renderAll();

  requestAnimationFrame(animate);

})();

</script>

</body>
</html>