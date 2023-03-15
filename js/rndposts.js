jQuery(document).ready(()=>{


    setTimeout(()=>{

        if(typeof ARPosts != "undefined" && ARPosts.length>0){
            display_next(0);
        }


    },2000)


    function display_next(i){




        console.log(i);

        const iframe = document.getElementById('cam');
        const innerDoc = iframe.contentDocument;
        const nodes  = innerDoc.querySelectorAll('a-entity[text]');
        const fronttext = nodes[0];
        const shadowtext = nodes[1];
        const authortext = nodes[2];
        const authorback = nodes[3];



        const base_url =  KtCube.assetsUrl;


        let post = ARPosts[i];

        //console.log(post);
        console.log(post.author);

        console.log(authortext.components);


        fronttext.components.text.data.color = post.color;
        authortext.components.text.data.color = post.color;

        fronttext.components.text.data.value = post.text;
        shadowtext.components.text.data.value = post.text;
        authortext.components.text.data.value = post.author;
        authorback.components.text.data.value = post.author;



        if(post.font){
            fronttext.components.text.data.font = base_url+ post.font +'.json';
            shadowtext.components.text.data.font = base_url+ post.font +'.json';

        }



        shadowtext.components.text.updateProperties();
        fronttext.components.text.updateProperties();
        authortext.components.text.updateProperties();
        authorback.components.text.updateProperties();
        if(post.scale){
            let s = post.scale*2;

            if(s > 2.5) s= 2.5;
            fronttext.setAttribute('scale', s + ' ' + s + ' ' + s);
            //shadowtext.setAttribute('scale', s + ' ' + s + ' ' + s);

        }

        i++;
        if(i<ARPosts.length){
            setTimeout(()=>{
                display_next(i);
            }, 2000);

        }else{
            setTimeout(()=>{
                location.reload();
            }, 8000);

        }


    }


});
