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
  if (settings.cookie_duration > 0) {
    setCookie("popup_shown", "1", settings.cookie_duration);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  if (!settings.enabled) return;

  // Detect mobile device
  const isMobile = /Mobi|Android|iPhone/i.test(navigator.userAgent);

  //  Override trigger on mobile to delay
  const effectiveTrigger = isMobile ? "delay" : settings.trigger;

  const closeBtn = document.getElementById("popup-close");
  const overlay = document.getElementById("popup-overlay");

  if (closeBtn) closeBtn.addEventListener("click", closePopup);
  if (overlay) overlay.addEventListener("click", closePopup);

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
  if (settings.trigger === "scroll") {
    const threshold = settings.scroll_percent || 30;

    window.addEventListener("scroll", function onScroll() {
      const scrollTop = window.scrollY;
      const docHeight =
        document.documentElement.scrollHeight - window.innerHeight;
      const scrolled = (scrollTop / docHeight) * 100;

      if (scrolled >= threshold) {
        showPopup();
        window.removeEventListener("scroll", onScroll);
      }
    });
  }
});
