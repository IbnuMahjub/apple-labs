<!doctype html>
<html>
<head>
  <title>Interactive Canvas TV Preview</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

  <style>
    body {
      margin: 0;
      background: #111;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    canvas {
      border: 2px solid #444;
    }
  </style>
</head>

<body>

<canvas id="canvas" width="900" height="500"></canvas>

<script>

const canvas = new fabric.Canvas('canvas', {
  selection: false,
  interactive: false
});

// ===================== STATE =====================
let focusIndex = 0;
let apps = [];

// ===================== DATA =====================
const sampleData = {
  objects: [
    {
      type: "rect",
      left: 300,
      top: 150,
      width: 250,
      height: 180,
      fill: "rgba(0,0,0,0.1)",
      stroke: "#00aaff",
      strokeWidth: 2
    },
    {
      type: "image",
      left: 400,
      top: 200,
      scaleX: 0.2,
      scaleY: 0.2,
      src: "https://cdn-icons-png.flaticon.com/512/5977/5977590.png",
      appType: "netflix"
    },
    {
      type: "image",
      left: 550,
      top: 200,
      scaleX: 0.2,
      scaleY: 0.2,
      src: "https://cdn-icons-png.flaticon.com/512/1384/1384060.png",
      appType: "youtube"
    }
  ]
};

// ===================== LOAD =====================
function loadCanvas(data) {

  data.objects.forEach(obj => {

    if (obj.type === "image") {

      fabric.Image.fromURL(obj.src, function(img) {

        img.set({
          left: obj.left,
          top: obj.top,
          scaleX: obj.scaleX,
          scaleY: obj.scaleY,
          selectable: false,
          evented: false,
          appType: obj.appType
        });

        canvas.add(img);

        apps.push(img); // 🔥 masuk ke list navigation

        canvas.renderAll();

        renderFocus();

      }, { crossOrigin: 'anonymous' });

    }

    if (obj.type === "rect") {

      const rect = new fabric.Rect({
        left: obj.left,
        top: obj.top,
        width: obj.width,
        height: obj.height,
        fill: obj.fill,
        stroke: obj.stroke,
        strokeWidth: obj.strokeWidth,
        selectable: false,
        evented: false
      });

      canvas.add(rect);
    }
  });
}

// ===================== FOCUS RENDER =====================
function renderFocus() {

  apps.forEach((obj, i) => {

    if (!obj) return;

    obj.set({
      stroke: i === focusIndex ? "yellow" : null,
      strokeWidth: i === focusIndex ? 6 : 0
    });
  });

  canvas.renderAll();
}

// ===================== KEYBOARD NAVIGATION =====================
document.addEventListener("keydown", function(e) {

  if (!apps.length) return;

  if (e.key === "ArrowRight") {
    focusIndex++;
    if (focusIndex >= apps.length) focusIndex = 0;
    renderFocus();
  }

  if (e.key === "ArrowLeft") {
    focusIndex--;
    if (focusIndex < 0) focusIndex = apps.length - 1;
    renderFocus();
  }

  if (e.key === "Enter") {

    const app = apps[focusIndex];

    if (!app) return;

    if (app.appType === "netflix") {
      window.location.href = "https://www.netflix.com";
    }

    if (app.appType === "youtube") {
      window.location.href = "https://www.youtube.com";
    }
  }
});

// ===================== INIT =====================
loadCanvas(sampleData);

</script>

</body>
</html>