(function () {
  function init() {
    const root = document.getElementById('custom-hr-card-root');
    if (!root) return;

    const entityId = root.dataset.entityId || null;
    const entityTypeId = root.dataset.entityTypeId || null;

    console.log('Custom HR Card init, entityId:', entityId);

    const form = new FormData();
    form.append('entityId', entityId);
    form.append('entityTypeId', entityTypeId);

    fetch('/local/tools/custom_hr_card_ajax.php', {
      method: 'POST',
      body: form,
      credentials: 'same-origin',
    })
      .then((r) => r.json())
      .then((data) => {
        console.log('AJAX response:', data);

        root.innerHTML =
          '<pre style="background:#f7f7f7;padding:12px;border-radius:8px;overflow:auto;max-width:100%;">' +
          escapeHtml(JSON.stringify(data, null, 2)) +
          '</pre>';
      })
      .catch((err) => {
        console.error('AJAX error:', err);
        root.innerHTML =
          '<div style="color:#b00">AJAX error: ' + escapeHtml(String(err)) + '</div>';
      });
  }

  function escapeHtml(s) {
    return String(s)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();