<template>
    <section class="p-questions">
        <h3 class="p-questions__title">よくある質問</h3>
        <div class="p-questions__list">
            <dl class="p-questions__items" v-on:click="toggle('1')">
                <dt class="p-questions__question">
                    Q. サイトの利用は無料ですか？
                </dt>
                <dd
                    class="p-questions__answer"
                    v-show="ShowContents.indexOf('1') >= 0"
                >
                    <p><span>A</span>. サイトの登録・利用は無料です。</p>
                </dd>
            </dl>
            <dl class="p-questions__items" v-on:click="toggle('2')">
                <dt class="p-questions__question">
                    Q. 買ったものはいつまで食べれますか？
                </dt>
                <dd
                    class="p-questions__answer"
                    v-show="ShowContents.indexOf('2') >= 0"
                >
                    <p>
                        <span>A</span>. 消費期限が切れるまでお食べいただけます。
                    </p>
                </dd>
            </dl>
            <dl class="p-questions__items" v-on:click="toggle('3')">
                <dt class="p-questions__question">
                    Q. キャンセルはできますか？
                </dt>
                <dd
                    class="p-questions__answer"
                    v-show="ShowContents.indexOf('3') >= 0"
                >
                    <p>
                        <span>A</span>.
                        注文履歴又は商品ページよりキャンセルが可能です。
                    </p>
                </dd>
            </dl>
            <dl class="p-questions__items" v-on:click="toggle('4')">
                <dt class="p-questions__question">Q. 配送は可能ですか？</dt>
                <dd
                    class="p-questions__answer"
                    v-show="ShowContents.indexOf('4') >= 0"
                >
                    <p><span>A</span>. 配送はいたしかねます。</p>
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
            ShowContents: [],
        };
    },
    methods: {
        toggle: function (data) {
            if (this.ShowContents.indexOf(data) >= 0) {
                this.ShowContents = this.ShowContents.filter((n) => n !== data);
            } else {
                this.ShowContents.push(data);
            }
        },
    },
};
</script>
