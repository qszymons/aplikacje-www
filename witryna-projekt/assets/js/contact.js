// Symulacja wysyłania formularza kontaktowego (frontend)
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");
  const btn = document.getElementById("sendBtn");
  const status = document.getElementById("formStatus");

  if (!form || !btn || !status) return;

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    // prosta walidacja (HTML required już działa, ale zostawiamy)
    const email = form.elements["email"].value.trim();
    const temat = form.elements["temat"].value.trim();
    const tresc = form.elements["tresc"].value.trim();

    if (!email || !temat || !tresc) {
      status.className = "form-status err";
      status.textContent = "Uzupełnij wszystkie pola.";
      return;
    }

    // start animacji
    btn.disabled = true;
    const oldText = btn.textContent;
    btn.textContent = "Wysyłanie...";
    status.className = "form-status loading";
    status.textContent = "Wysyłam wiadomość (symulacja)";

    // symulacja opóźnienia wysyłki
    setTimeout(() => {
      status.className = "form-status ok";
      status.textContent = "Wiadomość wysłana (symulacja). Dzięki.";

      form.reset();

      // przywróć przycisk po chwili
      setTimeout(() => {
        btn.disabled = false;
        btn.textContent = oldText;
        // zostaw status, albo wyczyść:
        // status.textContent = "";
      }, 900);

    }, 1500);
  });
});
