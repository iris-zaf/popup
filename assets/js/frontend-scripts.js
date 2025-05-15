function getCookie(name) {
  const match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
  return match ? match[2] : null;
}

function setCookie(name, value, days) {
  const expires = new Date(Date.now() + days * 86400000).toUTCString();
  document.cookie = `${name}=${value}; expires=${expires}; path=/`;
}

function showPopup() {
  if (getCookie("popup_shown")) return;
  document.getElementById("popup").style.display = "block";
  document.getElementById("popup-overlay").style.display = "block";
}

function closePopup() {
  document.getElementById("popup").style.display = "none";
  document.getElementById("popup-overlay").style.display = "none";
  setCookie("popup_shown", "1", settings.cookie_duration || 1);
}

document.addEventListener("DOMContentLoaded", () => {
  if (!settings.enabled) return;

  if (settings.trigger === "delay") {
    const delayTime = settings.delay || 5;
    setTimeout(showPopup, delayTime * 1000);
  }

  if (settings.trigger === "exit-intent") {
    document.addEventListener("mouseleave", (e) => {
      if (e.clientY < 0) {
        showPopup();
      }
    });
  }
});
