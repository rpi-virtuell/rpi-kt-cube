jQuery(document).ready(($) => {

    $iframe = jQuery('iframe');

    /**
     * Check, when AR Scene is complete initialized then run start
     *
     * @type {number}
     */
    window.check_scene_loaded = setInterval(()=>{

        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const item = innerDoc.querySelector('a-entity[messagetext]');

        if(typeof item.components === "object" && item.components.hasOwnProperty('text')){
            clearInterval(window.check_scene_loaded);
            console.log('AR Loaded');
            start();
        }


    },100)


    /**
     * init UI Buttons
     */
    function start(){
        KtCube.currentpos = 0;
        KtCube.ModelPosition = {x:0,y:0,z:0};
        KtCube.currentY = 0;


        if (typeof ARPosts != "undefined" && ARPosts.length > 0) {


            $iframe = jQuery('iframe');
            $right = $iframe.contents().find('.cam-right-arrow');
            $left = $iframe.contents().find('.cam-left-arrow');


            $iframe.contents().find('#text-zoom-plus').on('click' , (event) => {
                KtCube.currentscale = KtCube.currentscale + KtCube.zoomfactor;
                KtCube.currentpos = KtCube.currentpos  + 0.05;
                KtCube.currentY = KtCube.currentY  + 0.05;
                let pos = {
                    x: KtCube.ModelPosition.x,
                    y: KtCube.ModelPosition.y  + KtCube.currentY,
                    z: KtCube.ModelPosition.z
                };
                zoom(KtCube.currentscale,pos);
                return false;
            });
            $iframe.contents().find('#text-zoom-minus').on('click' , (event) => {
                KtCube.currentscale = KtCube.currentscale - KtCube.zoomfactor;
                KtCube.currentY = KtCube.currentY  - 0.05;
                let pos = {
                    x: KtCube.ModelPosition.x,
                    y: KtCube.ModelPosition.y  + KtCube.currentY,
                    z: KtCube.ModelPosition.z
                };
                zoom(KtCube.currentscale,pos);
                return false;
            });

            $right.on("click", (event) => {
                display_next('right');

            });
            $left.on("click", (event) => {
                display_next('left');
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

    function zoom(factor,pos){
        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        for (const fronttext of innerDoc.querySelectorAll('a-entity[messagecontainer]')) {
            if (factor > 0) {
                fronttext.setAttribute('scale', factor + ' ' + factor + ' ' + factor);
            }
        }
        for (const model of innerDoc.querySelectorAll('a-gltf-model[logo]')) {
            if (factor > 0) {
                model.setAttribute('position', pos.x+' '+pos.y+' '+pos.z);
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


        for (const model of innerDoc.querySelectorAll('a-gltf-model[logo]')) {
            model.setAttribute('position', KtCube.ModelPosition.x+' '+KtCube.ModelPosition.y+' '+KtCube.ModelPosition.z);
        }
        innerDoc.getElementById('cam-id').innerHTML = post.id;

    }


});
