
document.addEventListener("DOMContentLoaded", function () {
    const trailerButton = document.getElementById('watch-trailer-btn');
    trailerButton.addEventListener('click', function (e) {
        e.preventDefault();
        const trailerContainer = document.getElementById('trailer-container')
        trailerContainer.classList.add('active')
    });

    const closeTrailerButton = document.getElementById('close-trailer-btn');
    const videoPlayer = document.getElementById('video-player');
    closeTrailerButton.addEventListener('click', function (e) {
        e.preventDefault()
        videoPlayer.pause();
        const trailerContainer = document.getElementById('trailer-container')
        trailerContainer.classList.remove('active')
    });
})