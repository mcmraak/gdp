var doc = new Vue({
    el: '#gdp',
    delimiters: ['${','}'],
    data: {
        processed: false,
        doc_id:0
    },
    mounted: function () {
        this.doc_id = $('[doc-id]').attr('doc-id');
        console.log(this.doc_id);
    },
    methods: {
        parse: function()
        {
            this.processed = true;
            var $this = this;
            console.log($this.doc_id);
            $.ajax({
                type: 'post',
                url: location.origin + '/zen/gdp/api/parser/doc',
                data: {doc_id:$this.doc_id},
                success: function () {
                    location.reload();
                }
            });
        }
    }
});