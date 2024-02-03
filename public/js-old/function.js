export function setCookie(name, value, exp)  {
    var now = new Date();
    var expirationTime = new Date(now.getTime() + exp * 1000);
    document.cookie = name + "=" + value + "; expires=" + expirationTime.toUTCString() + "; path=/";
}

export function getCookie(name) {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();
        if (cookie.startsWith(name + "=")) {
            return cookie.substring(name.length + 1, cookie.length);
        }
    }
    
    return null;
}

