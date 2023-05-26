jQuery(document).ready($ => {

    $('.acf-form').prepend('<iframe id="viewer" style="height:45vh; width: 100%"  src=' + KtCube.pluginUrl + 'viewer.php> </iframe>')
    $('.acf-radio-list input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[text]')) {

            enti.components.text.data.font = KtCube.assetsUrl + $(e.target).val() + '.json'
            enti.components.text.updateProperties();
        }
    })
    $('.acf-field-textarea textarea').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[messagetext]')) {
            enti.components.text.data.value = $(e.target).val();
            enti.components.text.updateProperties();
        }
    })
    $('.acf-field-textarea textarea').on('keyup', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[messagetext]')) {
            enti.components.text.data.value = $(e.target).val();
            enti.components.text.updateProperties();
        }
    })
    $('.acf-field-text input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[authortext]')) {
            enti.components.text.data.value = $(e.target).val();
            enti.components.text.updateProperties();
        }
    })
    $('.acf-field-text input').on('keyup', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[authortext]')) {
            enti.components.text.data.value = $(e.target).val();
            enti.components.text.updateProperties();
        }
    })
    $('.acf-color-picker input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        // let fronttextnode = innerDoc.querySelectorAll('a-entity[front]');
        // fronttextnode.components.text.data.color = $(e.target).val();
        // fronttextnode.components.text.updateProperties();
        for (const enti of innerDoc.querySelectorAll('a-entity[front]')) {
            enti.components.text.data.color = $(e.target).val();
            enti.components.text.updateProperties();
        }
    })
    $('.acf-field-range input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        for (const enti of innerDoc.querySelectorAll('a-entity[messagecontainer]')) {
            var scale = $(e.target).val();
            enti.setAttribute('scale', scale + ' ' + scale + ' ' + scale);
        }
    })
    $('.acf-field-true-false[data-name="model"] input').on('change', function (e) {
        const iframe = document.getElementById('viewer');
        const innerDoc = iframe.contentDocument;
        const display_model = e.target.checked;
        for (const enti of innerDoc.querySelectorAll('a-entity[schild]')) {
            if(display_model){
                enti.setAttribute('position', '0 0 -0.2');
            }else{
                enti.setAttribute('position', '-1000 0 -0.2');
            }

        }
    })


    $('#cam').ready($ => {
        let window_size = $(window).height();
        let header_size = $('#header').height();
        $('#cam').height(window_size - header_size);


    });
    $(window).on('resize', ()=>{
        let window_size = $(window).height();
        let header_size = $('#header').height();
        $('#cam').height(window_size - header_size);
    })

});
