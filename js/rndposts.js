jQuery(document).ready(($) => {


    setTimeout(() => {

        if (typeof ARPosts != "undefined" && ARPosts.length > 0) {
            KtCube.postnuber = -1;
            display_next('right');


            $iframe = jQuery('iframe');
            $right = $iframe.contents().find('.cam-right-arrow');
            $left = $iframe.contents().find('.cam-left-arrow');


            $iframe.contents().find('#cam-id').on('click' , (event) => {
                const iframe = document.getElementById('cam');
                const innerDoc = iframe.contentDocument;
                const camera = innerDoc.querySelector('a-camera');
                console.log(camera);

                camera.setAttribute('zoom',3);
                console.log(camera);


            });

            $right.on("click", (event) => {
                display_next('right');

            });
            $left.on("click", (event) => {
                display_next('left');
            });


        }

    }, 2000)

    function display_next(dir) {

        if (dir === 'left') {
            KtCube.postnuber--;
        } else {
            KtCube.postnuber++;
        }

        var i = KtCube.postnuber;

        if (i < 0) {
            i = ARPosts.length - 1;
            KtCube.postnuber = i;
        } else if (i > ARPosts.length - 1) {
            i = 0;
            KtCube.postnuber = i;
        }


        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const textnodes = innerDoc.querySelectorAll('a-entity[text]');

        const messages = innerDoc.querySelectorAll('a-entity[messagetext]');
        const front = innerDoc.querySelectorAll('a-entity[front]');
        const authors = innerDoc.querySelectorAll('a-entity[authortext]');


        const base_url = KtCube.assetsUrl;


        let post = ARPosts[i];

        console.log(KtCube.postnuber, i, ARPosts.length, post);


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
                let s = post.scale * 3;

                fronttext.setAttribute('scale', s + ' ' + s + ' ' + s);


            }
        }
        innerDoc.getElementById('cam-id').innerHTML = post.id;

    }


});
