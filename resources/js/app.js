const showToast = (message) => {
    const root = document.querySelector('[data-toast-root]');
    const toast = root?.querySelector('[data-toast]');

    if (!root || !toast) {
        return;
    }

    toast.textContent = message;
    root.classList.remove('hidden');
    root.classList.add('flex');

    window.clearTimeout(root.hideTimeout);
    root.hideTimeout = window.setTimeout(() => {
        root.classList.add('hidden');
        root.classList.remove('flex');
    }, 2400);
};

const initToastButtons = () => {
    document.querySelectorAll('[data-toast-message]').forEach((button) => {
        button.addEventListener('click', () => {
            showToast(button.dataset.toastMessage);
        });
    });
};

const initPrintButtons = () => {
    document.querySelectorAll('[data-print-page]').forEach((button) => {
        button.addEventListener('click', () => window.print());
    });
};

const initRegistrationForm = () => {
    const form = document.querySelector('[data-registration-form]');

    if (!form) {
        return;
    }

    const pathInputs = [...form.querySelectorAll('[data-path-input]')];
    const panels = [...form.querySelectorAll('[data-path-fields]')];
    const conditionalInputs = [...form.querySelectorAll('[data-conditional-input]')];
    const dependentSections = [...form.querySelectorAll('[data-path-dependent-section]')];
    const pathNotice = form.querySelector('[data-path-notice]');
    const submitButton = form.querySelector('[data-submit-button]');

    const syncPathCards = (selectedPath) => {
        pathInputs.forEach((input) => {
            const card = input.closest('label');

            if (!card || input.disabled) {
                return;
            }

            const isSelected = input.value === selectedPath;
            card.classList.toggle('border-slate-950', isSelected);
            card.classList.toggle('bg-slate-100', isSelected);
            card.classList.toggle('shadow-sm', isSelected);
            card.classList.toggle('shadow-slate-300/70', isSelected);
        });
    };

    const updateVisibleFields = () => {
        const selectedPath = pathInputs.find((input) => input.checked)?.value;
        const hasSelectedPath = Boolean(selectedPath);

        panels.forEach((panel) => {
            const isActive = panel.dataset.pathFields === selectedPath;
            panel.classList.toggle('hidden', !isActive);
        });

        conditionalInputs.forEach((field) => {
            field.required = field.dataset.conditionalInput === selectedPath;
        });

        dependentSections.forEach((section) => {
            section.classList.toggle('opacity-50', !hasSelectedPath);
            section.classList.toggle('pointer-events-none', !hasSelectedPath);

            section.querySelectorAll('[data-path-required-message]').forEach((message) => {
                message.classList.toggle('hidden', hasSelectedPath);
            });

            section.querySelectorAll('input, select, textarea, button[type="submit"]').forEach((field) => {
                const conditionalPanel = field.closest('[data-path-fields]');

                if (conditionalPanel) {
                    field.disabled = !hasSelectedPath || conditionalPanel.dataset.pathFields !== selectedPath;
                    return;
                }

                field.disabled = !hasSelectedPath;
            });
        });

        if (submitButton) {
            submitButton.disabled = !hasSelectedPath;
        }

        if (pathNotice) {
            pathNotice.classList.toggle('hidden', hasSelectedPath);
        }

        syncPathCards(selectedPath);
    };

    pathInputs.forEach((input) => input.addEventListener('change', updateVisibleFields));

    form.addEventListener('submit', (event) => {
        updateVisibleFields();

        const selectedPath = pathInputs.find((input) => input.checked)?.value;

        if (!selectedPath) {
            event.preventDefault();
            showToast('Pilih jalur pendaftaran terlebih dahulu.');
            pathNotice?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        const parentPhone = form.querySelector('[name="parent_phone"]');

        if (parentPhone) {
            const digitsOnly = parentPhone.value.replace(/\D/g, '');

            if (digitsOnly.length < 10) {
                parentPhone.setCustomValidity('Nomor HP orang tua/wali harus berisi minimal 10 digit angka.');
            } else {
                parentPhone.setCustomValidity('');
            }
        }

        if (!form.checkValidity()) {
            event.preventDefault();
            form.reportValidity();
            showToast('Lengkapi field wajib terlebih dahulu.');
        }
    });

    updateVisibleFields();
};

const initRegistrantDetail = () => {
    const wrapper = document.querySelector('[data-detail-form]');

    if (!wrapper) {
        return;
    }

    const saveButton = wrapper.querySelector('[data-detail-save]');
    const statusField = wrapper.querySelector('[data-detail-status]');
    const noteField = wrapper.querySelector('[data-detail-note]');
    const feedback = wrapper.querySelector('[data-detail-feedback]');

    saveButton?.addEventListener('click', () => {
        if (feedback) {
            feedback.textContent = `Status diubah ke "${statusField?.selectedOptions?.[0]?.textContent ?? 'status baru'}" dengan catatan "${noteField?.value.trim() || '-'}".`;
        }

        showToast('Perubahan status belum tersimpan ke backend.');
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initToastButtons();
    initPrintButtons();
    initRegistrationForm();
    initRegistrantDetail();
});
