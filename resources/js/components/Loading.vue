<template>
    <div class="c-mask" v-if="isLoading === true">
        <div class="loading">
            <vue-loading
                type="spiningDubbles"
                color="#333"
                :size="{ width: '50px', height: '50px' }"
            ></vue-loading>
        </div>
    </div>
</template>

<script>
import { VueLoading } from "vue-loading-template";

export default {
    props: {
        isLoading: Boolean,
    },
    components: {
        VueLoading,
    },
};
</script>
