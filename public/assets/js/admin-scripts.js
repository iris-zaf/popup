function toggleDelayInput() {
  const trigger = document.getElementById("triggerSelect").value;
  document.getElementById("delayInput").style.display =
    trigger === "delay" ? "block" : "none";
  document.getElementById("scrollInput").style.display =
    trigger === "scroll" ? "block" : "none";
}

function toggleSettingsPanel() {
  const enabled = document.getElementById("enabledSelect").value;
  document.getElementById("settingsPanel").style.display =
    enabled === "1" ? "block" : "none";
}

document.addEventListener("DOMContentLoaded", () => {
  toggleSettingsPanel();
  toggleDelayInput();
});

function openPreview() {
  const frame = document.getElementById("previewFrame");
  const page = document.querySelector('[name="target_page"]').value;
  frame.src = `preview.php?page=${encodeURIComponent(page)}`;

  const modal = new bootstrap.Modal(document.getElementById("previewModal"));
  modal.show();
}
function launchPreview(formData) {
  fetch("preview.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((html) => {
      const frame = document.getElementById("previewFrame");
      frame.srcdoc = html;
      const modal = new bootstrap.Modal(
        document.getElementById("previewModal")
      );
      modal.show();
    })
    .catch((err) => {
      alert("❌ Preview failed to load.");
      console.error(err);
    });
}

function updateImageURL(input) {
  if (input.files.length > 0) {
    const fileName = input.files[0].name;
    document.getElementById("image_url_field").value = fileName;
  }
}
setTimeout(() => {
  const alert = document.querySelector(".alert");
  if (alert) {
    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
    bsAlert.close();
  }
}, 2500);
