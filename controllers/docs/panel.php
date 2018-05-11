<button doc-id="<?=$model->id?>" id="gdp"
        @click="parse()"
        class="parser-btn btn btn-primary oc-icon-refresh"
        :class="{processed:processed}">
    <?= e(trans('zen.gdp::lang.doc.parser')) ?>
</button>
<script src="/plugins/zen/gdp/assets/js/vue.min.js"></script>
<script src="/plugins/zen/gdp/assets/js/zen.gdn.doc.js"></script>