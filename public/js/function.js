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

export function getTimeAgo(timestamp) {
    const currentTimestamp = new Date();
    const targetTimestamp = new Date(timestamp);
    const secondsAgo = Math.floor((currentTimestamp - targetTimestamp) / 1000);

    // Hitung waktu dalam detik, menit, jam, hari
    const minutesAgo = Math.floor(secondsAgo / 60);
    const hoursAgo = Math.floor(minutesAgo / 60);
    const daysAgo = Math.floor(hoursAgo / 24);
    if (secondsAgo < 60) {
        return 'Just now';
    } else if (minutesAgo < 60) {
        return `${minutesAgo}${minutesAgo === 1 ? 'm' : 'm'} ago`;
    } else if (hoursAgo < 24) {
        return `${hoursAgo}${hoursAgo === 1 ? 'h' : 'h'} ago`;
    } else {
        return `${daysAgo}${daysAgo === 1 ? 'day' : 'days'} ago`;
    }
}

export function spinnerAction(elemetId, status) {
    const spinner = document.getElementById(elemetId)
    spinner.style.display = status
}

export function handleError(error) {
    console.log(error.response)
    if(error.response.status === 401){
        Swal.fire({
            width:"32em",
            position: "center",
            icon: "error",
            text: "Your session has ended, please log in again",
            showConfirmButton: false,
            timer: 1800
        });

        setInterval(() => {
            window.location.href = '/'; 
        }, 1800);
    }
    
}

