<div class="playlist-progress">
  <div class="progress-bar"></div>
  <div class="progress-text">0%</div>
</div>


<style>
  .playlist-progress {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
}

.progress-bar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #f1f1f1;
  position: relative;
}

.progress-bar:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: #00b300;
  transform: rotate(0deg);
}

.progress-text {
  margin-left: 20px;
}

</style>


<script>
  const videos = [
  { title: "Video 1", duration: 120 },
  { title: "Video 2", duration: 180 },
  { title: "Video 3", duration: 240 },
];

const progressBar = document.querySelector(".progress-bar");
const progressText = document.querySelector(".progress-text");

let totalDuration = videos.reduce((total, video) => total + video.duration, 0);

let progress = localStorage.getItem("playlist-progress");
if (progress) {
  progressBar.style.transform = `rotate(${progress}deg)`;
  progressText.textContent = `${progress}%`;
}

videos.forEach((video) => {
  video.element = document.createElement("video");
  video.element.src = video.src;
  video.element.addEventListener("timeupdate", updateProgress);
});

function updateProgress() {
  let currentTime = videos.reduce((total, video) => {
    return total + video.element.currentTime;
  }, 0);

  let progressPercentage = (currentTime / totalDuration) * 100;

  progressBar.style.transform = `rotate(${progressPercentage}deg)`;
  progressText.textContent = `${progressPercentage.toFixed(0)}%`;

  localStorage.setItem("playlist-progress", progressPercentage);
}

progressBar.addEventListener("click", (event) => {
  let boundingRect = event.target.getBoundingClientRect();
  let centerX = boundingRect.left + boundingRect.width / 2;
  let centerY = boundingRect.top + boundingRect.height / 2;
  let angle = Math.atan2(event.clientY - centerY, event.clientX - centerX);
  if (angle < 0) {
    angle += 2 * Math.PI;
  }
  let progressPercentage = (angle / (2 * Math.PI)) * 100;
  progressBar.style.transform = `rotate(${angle}rad)`;
  progressText.textContent = `${progressPercentage.toFixed(0)}%`;
  let currentTime = (progressPercentage / 100) * totalDuration;
  videos.forEach((video) => {
    video.element.currentTime = currentTime;
  });
  localStorage.setItem("playlist-progress", progressPercentage);
});

</script>