function closeAlertDeleted() {
  let closeIcon = document.querySelector("#closeIcon");
  let alert_deleted = document.querySelector(".alert-deleted");
  closeIcon.addEventListener("click", () => {
    alert_deleted.classList.toggle("slide-left");
    setTimeout(() => {
        alert_deleted.remove(alert_deleted);
      }, 1000);
  });
}
function closeAlertLoggedOff() {
  let closeIcon = document.querySelector("#closeIcon");
  let alert_loggedOff = document.querySelector(".alert-loggedOff");
  closeIcon.addEventListener("click", () => {
    alert_loggedOff.classList.toggle("slide-bottom");
    setTimeout(() => {
      alert_loggedOff.remove(alert_loggedOff);
      }, 1000);
  });
}

closeAlertDeleted();
closeAlertLoggedOff();

