let chatMessages;
let chatInputForm, chatInput;
window.addEventListener("load", function () {
    chatMessages = document.querySelector(".chatMessages");
    scrollChatToBottom();
    chatInputForm = document.querySelector("#chatInputForm");
    chatInput = document.querySelector(".chatInput");
    chatInputForm.addEventListener("submit", function (e) {
        // prevent form submission if no chat selected
        var params = new URLSearchParams(window.location.search);
        if (!params.get("selectedChat"))
            e.preventDefault();
        // prevent form submission if input is empty
        if (chatInput.value.trim().length == 0)
            e.preventDefault();
    });
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
