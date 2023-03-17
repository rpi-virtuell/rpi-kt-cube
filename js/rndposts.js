jQuery(document).ready(() => {


    setTimeout(() => {

        if (typeof ARPosts != "undefined" && ARPosts.length > 0) {
            display_next(0);
        }


    }, 2000)


    function display_next(i) {



        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const textnodes = innerDoc.querySelectorAll('a-entity[text]');

        const messages = innerDoc.querySelectorAll('a-entity[messagetext]');
        const front = innerDoc.querySelectorAll('a-entity[front]');
        const authors = innerDoc.querySelectorAll('a-entity[authortext]');



        const base_url = KtCube.assetsUrl;


        let post = ARPosts[i];

        //console.log(post);
        /*
        console.log(post.author);

        console.log(authortext.components);

        console.log(post.text)
*/

        for(const item of front){
            item.components.text.data.color = post.color;
            item.components.text.updateProperties();
        }
        for(const item of messages){
            item.components.text.data.value = post.text;
            item.components.text.updateProperties();
        }
        for(const item of authors){
            item.components.text.data.value = post.author;
            item.components.text.updateProperties();
        }
        for(const item of textnodes){
            if (post.font) {
                item.components.text.data.font = base_url + post.font + '.json';
                item.components.text.updateProperties();
            }
        }

        for(const fronttext of innerDoc.querySelectorAll('a-entity[messagecontainer]')){
            console.log('post.scale',post.scale);
            if (post.scale>0) {
                let s = post.scale * 2;
                console.log('post.scale calc',s);
                if (s > 2.5) s = 2.5;
                fronttext.setAttribute('scale', s + ' ' + s + ' ' + s);


            }
        }


        i++;

        $iframe = jQuery('iframe');
        $right = $iframe.contents().find('.cam-right-arrow');
        $left = $iframe.contents().find('.cam-left-arrow');


        if (i < ARPosts.length) {
            $left.on("click", (event) => {
                if(i-2<0){
                    i = ARPosts.length;
                    $left.unbind();
                }else{
                    i=i-2;
                }

                display_next(i);

            });

            $right.on("click", (event) => {
                display_next(i);

            });
        }else if(i >= ARPosts.length) {
            i = 0;
            $right.unbind();$left.unbind();
            display_next(i);

        }


    }


});
