<!doctype html>
<html>
<head>
  <title>Mini Canva Video Editor FIXED</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

  <style>
    body {
      margin: 0;
      background: #111;
      color: white;
      font-family: Arial;
    }

    .toolbar {
      padding: 10px;
      background: #222;
      display: flex;
      gap: 10px;
    }

    canvas {
      border: 1px solid #444;
      display: block;
      margin: 20px auto;
    }
  </style>
</head>

<body>

<div class="toolbar">
  <input type="file" id="upload" accept="video/*">
  <button onclick="addFrame()">Add Frame</button>
</div>

<canvas id="canvas" width="900" height="500"></canvas>

<script>
const canvas = new fabric.Canvas('canvas', {
  preserveObjectStacking: true,
  selection: true
});

let activeVideo = null;
let frame = null;

// ========================
// UPLOAD VIDEO
// ========================
document.getElementById('upload').addEventListener('change', function(e) {
  const file = e.target.files[0];
  const url = URL.createObjectURL(file);

  const videoEl = document.createElement('video');
  const source = document.createElement('source');

  videoEl.width = 1280;
  videoEl.height = 720;
  videoEl.muted = true;
  videoEl.loop = true;
  videoEl.playsInline = true;

  source.src = url;
  videoEl.appendChild(source);

  videoEl.onloadeddata = () => {
  console.log("video ready");

  const videoObj = new fabric.Image(videoEl, {
    left: 250,
    top: 150,
    originX: 'center',
    originY: 'center',
    objectCaching: false,
    selectable: true
  });

  // 🔥 FIX: paksa scale biar masuk canvas
  const scaleX = 1280 / videoEl.videoWidth;
  const scaleY = 720 / videoEl.videoHeight;

  videoObj.scaleX = scaleX;
  videoObj.scaleY = scaleY;

  activeVideo = videoObj;

  canvas.add(videoObj);
  videoEl.play();
};
});

// ========================
// ADD FRAME (RESIZABLE)
// ========================
function addFrame() {
  frame = new fabric.Rect({
    left: 300,
    top: 120,
    width: 300,
    height: 200,

    fill: 'rgba(0,0,0,0.05)',
    stroke: '#00aaff',
    strokeWidth: 2,

    selectable: true,
    evented: true,

    hasBorders: true,
    hasControls: true,

    cornerColor: '#00aaff',
    cornerSize: 10,
    transparentCorners: false
  });

  canvas.add(frame);
  canvas.setActiveObject(frame);
  frame.bringToFront();
}

// ========================
// VIDEO FOLLOW FRAME (CROP)
// ========================
canvas.on('object:moving', function(e) {
  if (!activeVideo || !frame) return;

  const obj = e.target;

  if (obj === activeVideo) {
    applyCrop();
  }

  if (obj === frame) {
    applyCrop();
  }
});

canvas.on('object:scaling', function(e) {
  if (e.target === frame) {
    applyCrop();
  }
});


function applyCrop() {
  if (!activeVideo || !frame) return;

  activeVideo.clipPath = new fabric.Rect({
    left: frame.left,
    top: frame.top,
    width: frame.width * frame.scaleX,
    height: frame.height * frame.scaleY,
    absolutePositioned: true
  });
}

// ========================
// RENDER LOOP
// ========================
(function animate() {
  canvas.renderAll();
  requestAnimationFrame(animate);
})();
</script>

</body>
</html>