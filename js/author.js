// Copy URL
const answer = document.getElementById("copyResult");
const copy   = document.getElementById("copyButton");
const selection = window.getSelection();
const range = document.createRange();
const textToCopy = document.getElementById("PerfilUrl")

copy.addEventListener('click', function(e) {
    range.selectNodeContents(textToCopy);
    selection.removeAllRanges();
    selection.addRange(range);
    const successful = document.execCommand('copy');
    if(successful){
        answer.innerHTML = 'Link copied successfully! Share on your social networks ❤️';
    } else {
        answer.innerHTML = 'Error when copying :(';  
    }
    window.getSelection().removeAllRanges()
});