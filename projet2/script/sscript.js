document.getElementById("contact-form").addEventListener("submit", async function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  const response = await fetch(form.action, {
    method: "POST",
    body: formData,
  });

  if (response.ok) {
    alert("Message envoyé !");
    form.reset();
  } else {
    alert("Une erreur est survenue.");
  }
});
