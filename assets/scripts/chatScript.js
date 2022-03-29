let chatMessages;
window.addEventListener("load", function () {
    chatMessages = document.querySelector(".chatMessages");
    scrollChatToBottom();
});
window.addEventListener("resize", function () {
    // if near the bottom, keep scroll position at the bottom
    if (chatMessages.scrollTop > chatMessages.scrollHeight - 350) {
        scrollChatToBottom();
    }
});
function scrollChatToBottom() {
    chatMessages.scrollTo(0, chatMessages.scrollHeight);
}
