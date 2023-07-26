<template lang="">
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags <Button @click.prevent="addModal=true"><Icon type="md-add" /> Add Tag</Button></p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Tag name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr>
                                <td>1</td>
                                <td class="_table_name">
                                    Manhattan's art center "Shed" opening
                                    ceremony
                                </td>
                                <td>Economy</td>
                                <td>
                                    <Button type="info" size="small">Info</Button>
                                    <Button type="error" size="small">Error</Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAG ADDING MODAL -->
            <Modal
                v-model="addModal"
                title="Add tag"
                :mask-closable="false"
                :closable='false'
                >
                <Input v-model="data.tagName" placeholder="Add tag name"/>

                <div slot='footer'>
                    <Button type="default" @click.prevent="addModal=false">Close</Button>
                    <Button type="primary" @click.prevent="addTag">Add tag</Button>
                </div>
            </Modal>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            data: {
                tagName: '',
            },
            addModal: false,
            isAdding: false,
        }
    },
    methods: {
        addTag() {
            if (this.data.tagName.trim() == '') return this.e('Oops !!!', 'Tag name is required');
        }
    },
    computed: {

    }
};
</script>
<style lang=""></style>
