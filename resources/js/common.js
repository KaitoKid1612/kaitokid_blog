export default {
    data() {
        return {};
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                });
            } catch (e) {
                return e.response;
            }
        },

        i(title, desc) {
            this.$Notice.info({
                title: title,
                desc: desc,
            });
        },
        s(title, desc) {
            this.$Notice.success({
                title: title,
                desc: desc,
            });
        },
        w(title, desc) {
            this.$Notice.warning({
                title: title,
                desc: desc,
            });
        },
        e(title, desc) {
            this.$Notice.error({
                title: title,
                desc: desc,
            });
        },
        swr(title, desc = "Something went wrong! Please try again.") {
            this.$Notice.error({
                title: title,
                desc: desc,
            });
        },
    },
};
