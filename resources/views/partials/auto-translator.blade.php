<script>
(function () {
    const translationMap = @json(trans('messages.client_translation_map'));
    if (!translationMap || Object.keys(translationMap).length === 0) {
        return;
    }

    const skipTags = ['SCRIPT', 'STYLE', 'NOSCRIPT'];

    function normalise(text) {
        return String(text || '').replace(/\s+/g, ' ').trim();
    }

    function translateValue(value) {
        const clean = normalise(value);
        return translationMap[clean] || value;
    }

    function translateTextNode(node) {
        const clean = normalise(node.nodeValue);
        if (!clean || !translationMap[clean]) {
            return;
        }
        node.nodeValue = node.nodeValue.replace(clean, translationMap[clean]);
    }

    function walk(node) {
        if (node.nodeType === Node.TEXT_NODE) {
            translateTextNode(node);
            return;
        }

        if (node.nodeType !== Node.ELEMENT_NODE || skipTags.includes(node.tagName)) {
            return;
        }

        Array.from(node.childNodes).forEach(walk);
    }

    document.querySelectorAll('[placeholder]').forEach(function (element) {
        element.setAttribute('placeholder', translateValue(element.getAttribute('placeholder')));
    });

    document.querySelectorAll('option').forEach(function (element) {
        const clean = normalise(element.textContent);
        if (translationMap[clean]) {
            element.textContent = translationMap[clean];
        }
    });

    walk(document.body);
})();
</script>
