jQuery(document).ready(()=>{


    setTimeout(()=>{

        if(typeof ARPosts != "undefined" && ARPosts.length>0){
            display_next(0);
        }


    },8000)


    function display_next(i){




        console.log(i);

        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const nodes  = innerDoc.querySelectorAll('a-entity[text]');
        const fronttext = nodes[0];
        const shadowtext = nodes[1];



        const base_url =  KtCube.assetsUrl;


        let post = ARPosts[i];

        console.log(post);



        fronttext.components.text.data.color = post.color;

        fronttext.components.text.data.value = post.text;
        shadowtext.components.text.data.value = post.text;

        if(post.font){
            fronttext.components.text.data.font = base_url+ post.font +'.json';
            shadowtext.components.text.data.font = base_url+ post.font +'.json';

        }



        shadowtext.components.text.updateProperties();
        fronttext.components.text.updateProperties();

        if(post.scale){
            let s = post.scale*5;

            fronttext.setAttribute('scale', s + ' ' + s + ' ' + s);
            shadowtext.setAttribute('scale', s + ' ' + s + ' ' + s);

        }

        i++;
        if(i<ARPosts.length){
            setTimeout(()=>{
                display_next(i);
            }, 8000);

        }else{
            setTimeout(()=>{
                location.reload();
            }, 8000);

        }



    }


});
