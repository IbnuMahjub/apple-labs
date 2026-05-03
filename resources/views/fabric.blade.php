<!doctype html>
<html>
<head>
  <title>Mini Canva TV Editor</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

  <style>
    body {
      margin: 0;
      background: #111;
      color: white;
      font-family: Arial;
      overflow: hidden;
    }

    .toolbar {
      padding: 10px;
      background: #222;
      display: flex;
      gap: 10px;
      align-items: center;
      height: 70px;
    }

    button,
    input {
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      background: #333;
      color: white;
      cursor: pointer;
    }

    button:hover {
      background: #444;
    }

    canvas {
      border-top: 1px solid #444;
      display: block;

      width: 100vw;
      height: calc(100vh - 70px);
    }
  </style>
</head>

<body>

<div class="toolbar">

  <input type="file" id="upload" accept="video/*">

  <button onclick="addFrame()">
    Add Frame
  </button>

  <button onclick="addNetflixButton()">
    Add Netflix
  </button>

  <button onclick="addYoutubeButton()">
    Add YouTube
  </button>

  <button onclick="exportJSON()">
    Generate JSON
  </button>

  <button onclick="openPreview()">
    Preview
  </button>

</div>

<canvas id="canvas" width="1920" height="1080"></canvas>

<script>

const canvas = new fabric.Canvas('canvas', {
  preserveObjectStacking: true,
  selection: true
});

let activeVideo = null;
let frame = null;

function uploadFile(file) {

  const formData = new FormData();
  formData.append('file', file);

  const meta = document.querySelector('meta[name="csrf-token"]');
  const token = meta ? meta.getAttribute('content') : null;

  return fetch('/upload-media', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': token,
      'Accept': 'application/json'
    },
    body: formData
  })
  .then(async res => {

    const text = await res.text();

    try {
      const json = JSON.parse(text);

      
      if (!json.url) {
        throw new Error("URL tidak ada di response");
      }

      return json;

    } catch (e) {
      console.log("SERVER RESPONSE ERROR:", text);
      throw e;
    }
  });
}

// ======================================
// UPLOAD VIDEO
// ======================================

document.getElementById('upload')
.addEventListener('change', function(e) {

  const file = e.target.files[0];
  if (!file) return;

  uploadFile(file).then(res => {

    const url = res.url; // 👈 ini URL asli dari server

    const videoEl = document.createElement('video');
    videoEl.src = url;

    videoEl.width = 1920;
    videoEl.height = 1080;

    videoEl.muted = true;
    videoEl.loop = true;
    videoEl.playsInline = true;

    videoEl.onloadeddata = () => {

      const videoObj = new fabric.Image(videoEl, {
        left: 960,
        top: 540,
        originX: 'center',
        originY: 'center',
        objectCaching: false,
        selectable: true
      });

      const scale = Math.min(
        1600 / videoEl.videoWidth,
        900 / videoEl.videoHeight
      );

      videoObj.scale(scale);

      videoObj.customType = 'video';
      videoObj.videoSrc = url; // 🔥 BUKAN blob lagi

      canvas.add(videoObj);
      canvas.sendToBack(videoObj);

      videoEl.play();
    };
  });
});

// ======================================
// ADD FRAME
// ======================================

function addFrame() {

  frame = new fabric.Rect({

    left: 300,
    top: 120,

    width: 400,
    height: 250,

    fill: 'rgba(0,0,0,0.05)',

    stroke: '#00aaff',
    strokeWidth: 3,

    selectable: true,
    evented: true,

    hasBorders: true,
    hasControls: true,

    cornerColor: '#00aaff',
    cornerSize: 12,
    transparentCorners: false
  });

  canvas.add(frame);

  canvas.setActiveObject(frame);

  frame.bringToFront();
}

// ======================================
// NETFLIX BUTTON
// ======================================

function addNetflixButton() {

  const group = new fabric.Group([

    new fabric.Rect({
      width: 260,
      height: 80,
      rx: 15,
      ry: 15,
      fill: '#E50914'
    }),

    new fabric.Text('NETFLIX', {
      fontSize: 34,
      fill: 'white',
      fontWeight: 'bold',
      originX: 'center',
      originY: 'center',
      left: 130,
      top: 40
    })

  ], {

    left: 300,
    top: 300,

    selectable: true,
    hasControls: true
  });

  group.appType = 'netflix';
  group.customType = 'netflix';

  canvas.add(group);
}

// ======================================
// YOUTUBE BUTTON
// ======================================

function addYoutubeButton() {

  const group = new fabric.Group([

    new fabric.Rect({
      width: 260,
      height: 80,
      rx: 15,
      ry: 15,
      fill: '#FF0000'
    }),

    new fabric.Triangle({
      width: 28,
      height: 28,
      fill: 'white',
      left: 90,
      top: 26,
      angle: 90
    }),

    new fabric.Text('YouTube', {
      fontSize: 30,
      fill: 'white',
      fontWeight: 'bold',
      left: 120,
      top: 22
    })

  ], {

    left: 700,
    top: 300,

    selectable: true,
    hasControls: true
  });

  group.appType = 'youtube';
  group.customType = 'youtube';

  canvas.add(group);
}

// ======================================
// APPLY CROP
// ======================================

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

// ======================================
// UPDATE CROP
// ======================================

canvas.on('object:moving', function(e) {

  if (!activeVideo || !frame) return;

  if (
    e.target === activeVideo ||
    e.target === frame
  ) {
    applyCrop();
  }
});

canvas.on('object:scaling', function(e) {

  if (e.target === frame) {
    applyCrop();
  }
});

// ======================================
// DOUBLE CLICK APP
// ======================================

canvas.on('mouse:dblclick', function(opt) {

  const obj = opt.target;

  if (!obj) return;

  if (obj.appType === 'netflix') {

    alert('Open Netflix App');
  }

  if (obj.appType === 'youtube') {

    alert('Open YouTube App');
  }
});


function exportJSON() {

  const json = canvas.toJSON();

  console.log(json);

  fetch('/canvas/save', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      title: 'Canvas 1',
      json: JSON.stringify(json)
    })
  })
  .then(res => res.json())
  .then(res => {
    alert('Saved to database!');
    console.log(res);
  })
  .catch(err => {
    console.error(err);
  });
}



// ======================================
// RENDER LOOP
// ======================================

(function animate() {

  canvas.renderAll();

  requestAnimationFrame(animate);

})();

</script>

</body>
</html>