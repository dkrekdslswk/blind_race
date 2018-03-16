<template>
    <div>
        <Minsu></Minsu>
        <Footer></Footer>
        <Modal></Modal>
        <!-- sibling elements will be set to margin-left:240px for `fixed` and `is-fixed=true` -->
    </div>
</template>

<script>
    // import Footer from './Footer.vue';
    import Minsu from './Minsu.vue';
    // import Modal from './Modal.vue';
    export default {
       components:{
             Minsu
            //  , Modal , Footer
       }
    }
</script>
