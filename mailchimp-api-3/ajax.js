var btnSubmit = document.getElementById("execPOSTRequest");

document.getElementById("execPOSTRequest").addEventListener("click", function(){
    addDisabledAttribute();
    execPostRequest();
});

var addDisabledAttribute = function() {
	btnSubmit.setAttribute('disabled', 'disabled');
}

function execPostRequest() {
    init();
} 

function init() {

    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'https://mcdev.dream.press/mailchimp-api-exec', true);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(null);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            var myObj = xhr.responseText;
            var myStatus = xhr.status;
            var xhrResponse = document.getElementById('xhrResponse');
            xhrResponse.classList.toggle('d-none');
            if(myStatus == 200){
                btnSubmit.removeAttribute('disabled');
                xhrResponse.innerHTML = 'You\'ve received a ' + myStatus + ', time to finish editing your NEW mailchimp campaigns!';
            }   else {
                xhrResponse.innerHTML = 'You\'ve received a ' + myStatus + 'Sorry, your request failed (see Kevin for help) :(';
                console.log(xhr.responseText);
            }
        }
    };

}