<template>
    <section class="p-questions">
        <h3 class="p-questions__title">よくある質問</h3>
        <div
            class="p-questions__list"
            v-for="(qa, index) in qaContents"
            v-bind:key="index"
        >
            <dl class="p-questions__items" v-on:click="toggle(qa.index)">
                <dt class="p-questions__question">Q. {{ qa.question }}</dt>
                <dd
                    class="p-questions__answer"
                    v-show="showContents.indexOf(qa.index) >= 0"
                >
                    <p class="p-questions__answer-text">
                        <span class="p-questions__answer-accent">A</span>.
                        {{ qa.answer }}
                    </p>
                </dd>
            </dl>
        </div>
    </section>
</template>
<script>
export default {
    name: "Questions",
    data() {
        return {
            showContents: [],
            qaContents: [
                {
                    index: 1,
                    question: "サイトの利用は無料ですか？",
                    answer: "サイトの利用・登録は無料です。",
                },
                {
                    index: 2,
                    question: "買ったものはいつまで食べれますか？",
                    answer: "消費期限が切れるまでお食べいただけます。",
                },
                {
                    index: 3,
                    question: "キャンセルはできますか？",
                    answer: "注文履歴又は商品ページよりキャンセルが可能です。",
                },
                {
                    index: 4,
                    question: "配送は可能ですか？",
                    answer: "配送はいたしかねます。",
                },
            ],
        };
    },
    methods: {
        toggle: function (data) {
            if (this.showContents.indexOf(data) >= 0) {
                this.showContents = this.showContents.filter((n) => n !== data);
            } else {
                this.showContents.push(data);
            }
        },
    },
};
</script>
