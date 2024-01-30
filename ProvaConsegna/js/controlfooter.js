// footerControl.js

function adjustContentHeight() {
    var footerHeight = document.querySelector('footer').offsetHeight;
    var viewportHeight = window.innerHeight;

    var content = document.querySelector('.content');

    // Adjust the content height to fill the remaining viewport space
    content.style.minHeight = (viewportHeight - footerHeight) + 'px';
}

// Initial adjustment on page load
adjustContentHeight();

window.addEventListener('resize', function() {
    adjustContentHeight();
});
