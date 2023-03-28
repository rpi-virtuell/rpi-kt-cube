jQuery(document).ready(($) => {

    $iframe = jQuery('iframe');

    /**
     * Check, when AR Scene is complete initialized then run start
     *
     * @type {number}
     */
    window.check_scene_loaded = setInterval(() => {

        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const item = innerDoc.querySelector('a-entity[messagetext]');

        if (typeof item.components === "object" && item.components.hasOwnProperty('text')) {
            clearInterval(window.check_scene_loaded);
            console.log('AR Loaded');
            start();
        }


    }, 100)


    /**
     * init UI Buttons
     */
    function start() {
        KtCube.currentpos = 0;
        KtCube.ModelPosition = {x: 0, y: 0, z: 0};
        KtCube.currentY = 0;


        if (typeof ARPosts != "undefined" && ARPosts.length > 0) {


            $iframe = jQuery('iframe');
            $right = $iframe.contents().find('.cam-right-arrow');
            $left = $iframe.contents().find('.cam-left-arrow');
            $link = $iframe.contents().find('#cam-post-id');
            $sharBtn = $iframe.contents().find('#cam-share-screenshot');


            $iframe.contents().find('#cam-text-zoom-plus').on('click', (event) => {
                KtCube.currentscale = KtCube.currentscale + KtCube.zoomfactor;
                KtCube.currentpos = KtCube.currentpos + 0.02;
                KtCube.currentY = KtCube.currentY + 0.02;
                let pos = {
                    x: KtCube.ModelPosition.x,
                    y: KtCube.ModelPosition.y + KtCube.currentY,
                    z: KtCube.ModelPosition.z
                };
                zoom(KtCube.currentscale, pos);

                return false;
            });
            $iframe.contents().find('#cam-text-zoom-minus').on('click', (event) => {
                KtCube.currentscale = KtCube.currentscale - KtCube.zoomfactor;
                KtCube.currentY = KtCube.currentY - 0.02;
                let pos = {
                    x: KtCube.ModelPosition.x,
                    y: KtCube.ModelPosition.y + KtCube.currentY,
                    z: KtCube.ModelPosition.z
                };
                zoom(KtCube.currentscale, pos);

                return false;
            });

            $right.on("click", (event) => {
                event.target.blur();
                display_next('right');

            });
            $left.on("click", (event) => {
                display_next('left');

            });
            $sharBtn.on("click", (event) => {
                share_screenshot();

            });
            $link.on("click", (event) => {
                navigator.share(get_share_data().data);

            });

            const iframe = document.getElementById('cam');
            const innerDoc = iframe.contentDocument;
            for (const model of innerDoc.querySelectorAll('a-gltf-model[logo]')) {
                let pos = model.getAttribute('position');
                KtCube.ModelPosition.x = pos.x;
                KtCube.ModelPosition.y = pos.y;
                KtCube.ModelPosition.z = pos.z;
                console.log(KtCube.ModelPosition)
            }
            console.log(KtCube.ModelPosition)
            KtCube.postnumber = -1;
            console.log(KtCube)

            display_next('right');


        }

    }

    function zoom(factor, pos) {
        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        for (const fronttext of innerDoc.querySelectorAll('a-entity[messagecontainer]')) {
            if (factor > 0) {
                fronttext.setAttribute('scale', factor + ' ' + factor + ' ' + factor);
            }
        }
        for (const model of innerDoc.querySelectorAll('a-gltf-model[logo]')) {
            if (factor > 0) {

                model.setAttribute('position', pos.x + ' ' + pos.y + ' ' + pos.z);

            }
        }

        /*
           const camera = innerDoc.querySelector('a-camera');
           console.log(camera);
           camera.setAttribute('zoom',factor);
           console.log(camera);
         */
    }

    function display_next(dir) {

        if (dir === 'left') {
            KtCube.postnumber--;
        } else {
            KtCube.postnumber++;
        }

        var i = KtCube.postnumber;

        if (i < 0) {
            i = ARPosts.length - 1;
            KtCube.postnumber = i;
        } else if (i > ARPosts.length - 1) {
            i = 0;
            KtCube.postnumber = i;
        }


        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const textnodes = innerDoc.querySelectorAll('a-entity[text]');

        const messages = innerDoc.querySelectorAll('a-entity[messagetext]');
        const front = innerDoc.querySelectorAll('a-entity[front]');
        const authors = innerDoc.querySelectorAll('a-entity[authortext]');


        const base_url = KtCube.assetsUrl;


        let post = ARPosts[i];

        console.log(KtCube.postnumber, i, ARPosts.length, post);


        for (const item of front) {
            item.components.text.data.color = post.color;
            item.components.text.updateProperties();
        }
        for (const item of messages) {
            item.components.text.data.value = post.text;
            item.components.text.updateProperties();
        }
        for (const item of authors) {
            item.components.text.data.value = post.author;
            item.components.text.updateProperties();
        }
        for (const item of textnodes) {
            if (post.font) {
                item.components.text.data.font = base_url + post.font + '.json';
                item.components.text.updateProperties();
            }
        }

        for (const fronttext of innerDoc.querySelectorAll('a-entity[messagecontainer]')) {
            if (post.scale > 0) {
                let s = post.scale * KtCube.scalefactor;
                KtCube.currentscale = s;
                fronttext.setAttribute('scale', s + ' ' + s + ' ' + s);

            }
        }
        for (const fronttext of innerDoc.querySelectorAll('a-entity[messagecontainer]')) {

            let y = get_top_position();
            let pos = fronttext.getAttribute('position');
            const startY = KtCube.ModelPosition.y - 0.3;
            y = startY + y;
            console.log('posY', y);
            fronttext.setAttribute('position', pos.x + ' ' + y + ' ' + pos.z);

        }


        for (const model of innerDoc.querySelectorAll('a-gltf-model[logo]')) {
            model.setAttribute('position', KtCube.ModelPosition.x + ' ' + KtCube.ModelPosition.y + ' ' + KtCube.ModelPosition.z);
        }
        innerDoc.getElementById('cam-id').innerHTML = post.id;

    }

    function get_share_data() {

        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;

        let id = innerDoc.querySelector('#cam-id').innerHTML;
        let message = innerDoc.querySelector('a-entity[messagetext]');


        return {
            data: {
                url: 'https://' + location.host + '/' + id,
                title: 'AR auf dem Kichentag: Halte deine Cam über das aktuelle Kirchentagsmotto und entdecke die #zeitansagen: ' + message.components.text.data.value,
                text: message.components.text.data.value,
            },
            id: id
        }
    }

    /**
     * https://github.com/hiukim/mind-ar-js/discussions/73
     *
     */
    function share_screenshot() {

        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;


        let id = get_share_data().id;

        const video = innerDoc.querySelector("video");
        video.pause();

        const canvas = innerDoc.createElement("canvas");

        let v_width = video.clientWidth * 2;
        let v_height = video.clientHeight * 2;

        canvas.width = v_width;
        canvas.height = v_height;

        let element = innerDoc.querySelector('video'),
            style = window.getComputedStyle(element),
            toppos = style.getPropertyValue('top');
        canvas.getContext('2d').drawImage(video, 0, parseFloat(toppos), v_width, v_height);

        let imgData = innerDoc.querySelector('a-scene').components.screenshot.getCanvas('perspective');

        canvas.getContext('2d').drawImage(imgData, 0, 0, v_width, v_height);

        video.play();

        let a = innerDoc.createElement('a');
        a.href = canvas.toDataURL("image/png");
        a.download = 'zeitansage-' + id + '.png';
        a.click();

        if (!navigator.userAgent.match(/chrome\/\d+/i)) {
            //funktioniert nicht wie erwartet.
        } else {
            //funktioniert nicht immer wie erwartet.

            canvas.toBlob((blob) => {
                const file = new File(
                    [blob],
                    'zeitansage.png',
                    {
                        type: blob.type,
                        lastModified: new Date().getTime()
                    }
                );
                navigator.share({
                    title: '#zeitansagen',
                    //url: canvas.toDataURL("image/png"),
                    files: [file]
                });

            }, "image/png");
        }

    }

    function get_top_position() {
        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const message = innerDoc.querySelector('a-entity[messagecontainer]');
        const lines = message.components.text.data.value.split("\n");

        const scale = message.getAttribute('scale');

        console.log('scale', scale);

        const h = 0.20;

        let counter = lines.length;
        for (const line of lines) {
            if (line.length > 30) {
                counter++;
            }
        }

        console.log('counter', counter);

        return counter * h * -1;

    }


});
