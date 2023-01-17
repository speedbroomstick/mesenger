
const { default: axios } = require('axios');
require('./bootstrap');
const messages_el = document.getElementById("messages2");
const username_input = getCookie('user_name');
const message_input = document.getElementById("message_input");
const message_form = document.getElementById("message_form2");
message_form.addEventListener('submit', function(e){
    e.preventDefault();
    let has_errors = false;
    if(message_input.value == ''){
        alert("Пожалуйста введите сообщение");
        has_errors = true;
    }
    if(has_errors){
        return;
    }
    const options =
    {
        method: 'post',
        url: 'send-message',
        data:{
            username: username_input,
            message: message_input.value
        }
    }
    axios(options);
});

window.Echo.channel('chat')
.listen('.message', (e) =>{
//messages_el.innerHTML += '<div class="message"><strong>'+ e.username + ':</strong>' + e.message + '</div>';
    messages_el.innerHTML += '<div class="chat__conversation-board__message-container"><div class="chat__conversation-board__message__person"> <div class="chat__conversation-board__message__person__avatar"><img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Monika Figi"/></div><span class="chat__conversation-board__message__person__nickname">Monika Figi</span> </div> <div class="chat__conversation-board__message__context"><div class="chat__conversation-board__message__bubble"> <span>'+ e.message +'</span></div> </div></div>';
});



function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
