jQuery(document).ready($ => {
    $('.acf-form').append('<iframe id="viewer" style="height:45vh; width: 100%"  src="https://ktwu.rpi-virtuell.de/wp-content/ktwu-iframe/viewer.php"> </iframe>')
    $('.acf-radio-list input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[text]')) {

            enti.components.text.data.font = 'https://ktwu.rpi-virtuell.de/wp-content/ktwu-iframe/assets/' + $(e.target).val() + '.json'
            enti.components.text.updateProperties();
        }
    })
    $('.acf-field-textarea textarea').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[text]')) {
            enti.components.text.data.value = $(e.target).val();
            enti.components.text.updateProperties();
        }
    })
    $('.acf-color-picker input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        let fronttextnode = innerDoc.querySelector('a-entity[fronttext]');
        fronttextnode.components.text.data.color = $(e.target).val();
        fronttextnode.components.text.updateProperties();
    })
    $('.acf-field-number input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[text]')) {
            var scale = $(e.target).val();
            enti.setAttribute('scale', scale + ' ' + scale + ' ' + scale);
        }
    })


});