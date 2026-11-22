import './bootstrap';


/* ========================================
   LACUNA — ARCHIVE STACK SHUFFLE
======================================== */

document.querySelectorAll('[data-photo-stack]').forEach((stack) => {

    const cards = Array.from(
        stack.querySelectorAll('[data-stack-card]')
    );

    const nextButton = stack.querySelector('[data-stack-next]');

    // Nothing to animate if fewer than two cards exist.
    if (cards.length < 2) return;

    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    );

    let timer = null;
    let pointerInside = false;
    let keyboardFocus = false;

    // Move every photograph one position backward.
    function advanceStack() {

        cards.forEach((card) => {

            const currentSlot = Number(card.dataset.slot);

            const nextSlot = (currentSlot + 1) % cards.length;

            card.dataset.slot = String(nextSlot);

        });

    }

    // Start automatic shuffle.
    function startShuffle() {

        if (
            timer !== null ||
            reducedMotion.matches ||
            pointerInside ||
            keyboardFocus ||
            document.hidden
        ) {
            return;
        }

        timer = window.setInterval(advanceStack, 6000);

    }

    // Stop automatic shuffle.
    function stopShuffle() {

        if (timer !== null) {
            window.clearInterval(timer);
            timer = null;
        }

    }

    // Check whether automatic movement should pause.
    function updateShuffle() {

        const shouldPause =
            pointerInside ||
            keyboardFocus ||
            document.hidden ||
            reducedMotion.matches;

        if (shouldPause) {
            stopShuffle();
        } else {
            startShuffle();
        }

    }

    // Pause when pointer enters the panel.
    stack.addEventListener('mouseenter', () => {

        pointerInside = true;
        updateShuffle();

    });

    stack.addEventListener('mouseleave', () => {

        pointerInside = false;
        updateShuffle();

    });

    // Pause when keyboard users interact with the panel.
    stack.addEventListener('focusin', () => {

        keyboardFocus = true;
        updateShuffle();

    });

    stack.addEventListener('focusout', (event) => {

        if (!stack.contains(event.relatedTarget)) {
            keyboardFocus = false;
            updateShuffle();
        }

    });

    // Manual shuffle button.
    nextButton?.addEventListener('click', () => {

        advanceStack();

    });

    // Pause when browser tab becomes inactive.
    document.addEventListener('visibilitychange', updateShuffle);

    // Respond to reduced-motion preference changes.
    reducedMotion.addEventListener?.('change', updateShuffle);

    // Initial activation.
    updateShuffle();

});
