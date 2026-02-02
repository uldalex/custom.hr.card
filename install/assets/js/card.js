(function () {
  function init() {
    const root = document.getElementById('custom-hr-card-root');
    if (!root) return;

    const entityId = root.dataset.entityId || null;

    console.log('Custom HR Card init, entityId:', entityId);

    // ===== CREATE MODE =====
    if (!entityId || entityId === '0') {
      root.innerHTML =
        '<button id="custom-hr-create" class="ui-btn ui-btn-primary">Создать</button>';

      const btn = document.getElementById('custom-hr-create');
      btn.addEventListener('click', function () {
        const form = new FormData();
        form.append('action', 'create');

        fetch('/local/tools/custom_hr_card_ajax.php', {
          method: 'POST',
          body: form,
          credentials: 'same-origin',
        })
          .then(r => r.json())
          .then(resp => {
            console.log('create response', resp);

            if (resp.status === 'success' && resp.data && resp.data.id) {
              const newId = resp.data.id;
              window.top.location.href =
                '/crm/type/1032/details/' + newId + '/';
            }
          })
          .catch(err => console.error(err));
      });

      return;
    }

    // ===== VIEW MODE (пока просто лог) =====
    console.log('View mode, ID =', entityId);
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