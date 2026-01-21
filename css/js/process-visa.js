// process-visa.js - light front-end validation and graceful submit
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('pv-form');
  const alertBox = document.getElementById('pv-alert');

  const showAlert = (msg, type='error') => {
    alertBox.style.display = 'block';
    alertBox.className = 'pv-alert ' + (type === 'success' ? 'success' : 'error');
    alertBox.innerText = msg;
  };

  form.addEventListener('submit', e => {
    e.preventDefault();
    alertBox.style.display = 'none';

    // basic client validation
    const required = [
      'country','visa_type','first_name','email','consent'
    ];
    let ok = true;
    for (const name of required){
      const el = form.elements[name];
      if (!el) continue;
      if ((el.type === 'checkbox' && !el.checked) || (!el.value || el.value.trim() === "")){
        ok = false;
        el.focus();
        showAlert('Please fill required fields (Country, Visa type, First name, Email, and consent).');
        break;
      }
    }
    if (!ok) return;

    // email format quick check
    const email = form.elements['email'].value;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      showAlert('Please enter a valid email address.');
      form.elements['email'].focus();
      return;
    }

    // show loading
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerText = 'Submitting...';

    // submit via fetch to process-visa.php
    const data = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      body: data,
      headers: {
        'Accept': 'application/json'
      }
    }).then(res => res.json())
      .then(resp => {
        if (resp.success) {
          showAlert(resp.message || 'Submission successful — we will contact you soon.', 'success');
          form.reset();
        } else {
          showAlert(resp.message || 'Submission failed. Please try again later.');
        }
      })
      .catch(err => {
        console.error(err);
        showAlert('An error occurred while submitting. Please try again later.');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Submit';
      });
  });
});
