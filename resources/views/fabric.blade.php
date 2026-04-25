<!doctype html>
<html>
<head>
  <title>TV UI + Canvas Navigation FINAL FIX</title>

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
      align-items: center;
    }

    button, input {
      padding: 10px 15px;
      background: #333;
      color: white;
      border: 1px solid #555;
      border-radius: 6px;
    }

    button:focus, input:focus {
      background: red;
      outline: 2px solid yellow;
      transform: scale(1.05);
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
  <input id="upload" type="file" accept="video/*">
  <button id="btnFrame" onclick="addFrame()">Frame</button>
  <button id="btnNetflix" onclick="addNetflixIcon()">Netflix</button>
  <button id="btnYoutube" onclick="addYoutubeIcon()">YouTube</button>
</div>

<canvas id="canvas" width="900" height="500"></canvas>

<script>
const canvas = new fabric.Canvas('canvas', {
  preserveObjectStacking: true,
  selection: false
});

//////////////////////////////
// 🔥 STATE
//////////////////////////////

const uiElements = [
  document.getElementById("upload"),
  document.getElementById("btnFrame"),
  document.getElementById("btnNetflix"),
  document.getElementById("btnYoutube")
];

let uiIndex = 0;
let mode = "ui";

//////////////////////////////
// 🎯 UI FOCUS
//////////////////////////////
function focusUI(i) {
  uiElements.forEach(el => el?.blur());
  uiElements[i]?.focus();
}

//////////////////////////////
// 🎯 SAFE OBJECT LIST
//////////////////////////////
function getObjects() {
  return canvas.getObjects().filter(o => o.selectable !== false);
}

//////////////////////////////
// 🎯 SAFE ACTIVE OBJECT (FIX PENTING)
//////////////////////////////
function getActiveSafe() {
  let active = canvas.getActiveObject();
  const objs = getObjects();

  if (!active && objs.length) {
    active = objs[0];
    canvas.setActiveObject(active);
  }

  return active;
}

//////////////////////////////
// 🎯 FIXED SPATIAL NAVIGATION
//////////////////////////////
function findNearest(direction) {
  const objs = getObjects();
  const active = getActiveSafe();

  if (!active || objs.length === 0) return null;

  const ax = active.left || 0;
  const ay = active.top || 0;

  let best = null;
  let minDist = Infinity;

  for (let obj of objs) {
    if (obj === active) continue;

    const ox = obj.left || 0;
    const oy = obj.top || 0;

    const dx = ox - ax;
    const dy = oy - ay;

    let valid = false;
    let dist = 0;

    if (direction === "right" && dx > 20) {
      valid = true;
      dist = dx*dx + dy*dy;
    }

    if (direction === "left" && dx < -20) {
      valid = true;
      dist = dx*dx + dy*dy;
    }

    if (direction === "down" && dy > 20) {
      valid = true;
      dist = dx*dx + dy*dy;
    }

    if (direction === "up" && dy < -20) {
      valid = true;
      dist = dx*dx + dy*dy;
    }

    if (valid && dist < minDist) {
      minDist = dist;
      best = obj;
    }
  }

  return best;
}

//////////////////////////////
// 🎮 KEY CONTROL (FIXED TOTAL)
//////////////////////////////
document.addEventListener("keydown", function(e) {

  if (["ArrowUp","ArrowDown","ArrowLeft","ArrowRight"].includes(e.key)) {
    e.preventDefault();
  }

  if (e.key === "Backspace") {
    mode = mode === "ui" ? "canvas" : "ui";

    if (mode === "ui") focusUI(uiIndex);
    return;
  }

  // ================= UI MODE =================
  if (mode === "ui") {

    switch (e.key) {

      case "ArrowRight":
      case "ArrowDown":
        uiIndex++;
        if (uiIndex >= uiElements.length) uiIndex = 0;
        focusUI(uiIndex);
        break;

      case "ArrowLeft":
      case "ArrowUp":
        uiIndex--;
        if (uiIndex < 0) uiIndex = uiElements.length - 1;
        focusUI(uiIndex);
        break;

      case "Enter":
        uiElements[uiIndex]?.click();
        break;
    }
  }

  // ================= CANVAS MODE =================
  if (mode === "canvas") {

    const active = getActiveSafe();
    let target = null;

    switch (e.key) {

      case "ArrowRight":
        target = findNearest("right");
        break;

      case "ArrowLeft":
        target = findNearest("left");
        break;

      case "ArrowDown":
        target = findNearest("down");
        break;

      case "ArrowUp":
        target = findNearest("up");
        break;

      case "Enter":

        if (active?.appType === "netflix") {
          window.location.href = "https://www.netflix.com";
        }

        if (active?.appType === "youtube") {
          window.location.href = "https://www.youtube.com";
        }

        return;
    }

    // 🔥 IMPORTANT FIX (STABLE SELECTION)
    if (target) {
      canvas.setActiveObject(target);
    } else if (active) {
      canvas.setActiveObject(active);
    }

    canvas.renderAll();
  }
});

//////////////////////////////
// 📁 VIDEO
//////////////////////////////
document.getElementById('upload').addEventListener('change', function(e) {
  const file = e.target.files[0];
  const url = URL.createObjectURL(file);

  const videoEl = document.createElement('video');
  videoEl.src = url;
  videoEl.muted = true;
  videoEl.loop = true;
  videoEl.playsInline = true;

  videoEl.onloadeddata = () => {

    const videoObj = new fabric.Image(videoEl, {
      left: 120,
      top: 120,
      selectable: true
    });

    videoObj.scaleX = 700 / videoEl.videoWidth;
    videoObj.scaleY = 400 / videoEl.videoHeight;

    canvas.add(videoObj);
    canvas.setActiveObject(videoObj);

    videoEl.play();
  };
});

//////////////////////////////
// 📦 FRAME
//////////////////////////////
function addFrame() {
  const frame = new fabric.Rect({
    left: 350,
    top: 150,
    width: 250,
    height: 180,
    fill: 'rgba(0,0,0,0.05)',
    stroke: '#00aaff',
    strokeWidth: 2,
    selectable: true
  });

  canvas.add(frame);
  canvas.setActiveObject(frame);
}

//////////////////////////////
// 🎬 NETFLIX
//////////////////////////////
function addNetflixIcon() {
  const iconUrl = "https://cdn-icons-png.flaticon.com/512/5977/5977590.png";

  fabric.Image.fromURL(iconUrl, function(img) {

    img.set({
      left: 400,
      top: 200,
      scaleX: 0.2,
      scaleY: 0.2,
      selectable: true
    });

    img.appType = "netflix";

    canvas.add(img);

    setTimeout(() => {
      canvas.setActiveObject(img);
      canvas.renderAll();
    }, 30);

  }, { crossOrigin: 'anonymous' });
}

//////////////////////////////
// ▶️ YOUTUBE
//////////////////////////////
function addYoutubeIcon() {
  const iconUrl = "https://cdn-icons-png.flaticon.com/512/1384/1384060.png";

  fabric.Image.fromURL(iconUrl, function(img) {

    img.set({
      left: 550,
      top: 200,
      scaleX: 0.2,
      scaleY: 0.2,
      selectable: true
    });

    img.appType = "youtube";

    canvas.add(img);

    setTimeout(() => {
      canvas.setActiveObject(img);
      canvas.renderAll();
    }, 30);

  }, { crossOrigin: 'anonymous' });
}

//////////////////////////////
// 🖱 CLICK
//////////////////////////////
canvas.on('mouse:down', function(e) {
  const obj = e.target;

  if (!obj) return;

  canvas.setActiveObject(obj);

  if (obj.appType === "netflix") {
    window.location.href = "https://www.netflix.com";
  }

  if (obj.appType === "youtube") {
    window.location.href = "https://www.youtube.com";
  }
});

//////////////////////////////
// 🚀 INIT
//////////////////////////////
setTimeout(() => {
  focusUI(uiIndex);
}, 300);

</script>

</body>
</html>