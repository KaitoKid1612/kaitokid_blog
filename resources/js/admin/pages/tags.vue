<template lang="">
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags <Button @click.prevent="addModal=true"><Icon type="md-add" /> Add Tag</Button></p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>ID</th>
                                <th>Tag name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
                                <td>{{ tag.id }}</td>
                                <td class="_table_name">{{ tag.tag_name }}</td>
                                <td>{{ tag.created_at }}</td>
                                <td>
                                    <Button type="info" size="small" @click.prevent="showEditModal(tag, i)">Edit</Button>
                                    <Button type="error" size="small" @click.prevent="showDeleteModal(tag, i)" :loading="tag.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- TAG ADDING MODAL -->
            <Modal
                v-model="addModal"
                title="Add tag"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="data.tagName" placeholder="Add tag name" />
                <div slot="footer">
                    <Button type="default" @click="addModal=false">Close</Button>
                    <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add tag'}}</Button>
                </div>
            </Modal>
            <!-- TAG EDIT MODAL -->
            <Modal
                v-model="editModal"
                title="Edit tag"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="editData.tagName" placeholder="Edit tag name" />
                <div slot="footer">
                    <Button type="default" @click="editModal=false">Close</Button>
                    <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit tag'}}</Button>
                </div>
            </Modal>
            <!-- DELETE TAG MODAL -->
            <Modal v-model="deleteModal" width="360">
                <p slot="header" style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
                <div style="text-align:center">
                    <p>Are you sure you want to delete tag?</p>
                </div>
                <div slot="footer">
                    <Button type="error" size="large" long :loading="isDeleting" :disable="isDeleting" @click.prevent="deleteTag">Delete</Button>
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
            isDeleting: false,
            tags: [],
            editData: {
                tagName: '',
            },
            editModal: false,
            index: -1,
            deleteModal: false,
            deleteItem: {},
            deletingIndex: 1
        }
    },
    methods: {
        async addTag() {
            if (this.data.tagName.trim() == '') {
                return this.e('Tag name is required');
            }
            const res = await this.callApi('post', 'app/create-tag', this.data);
            if (res.status === 201) {
                this.tags.unshift(res.data);
                this.s('Tag has been added successfully!');
                this.addModal = false;
                this.data.tagName = '';
            } else {
                if (res.status === 422) {
                    if (res.data.errors.tagName[0]) {
                        this.e(res.data.errors.tagName[0]);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editTag() {
            if (this.editData.tagName.trim() == '') {
                return this.e('Tag name is required');
            }
            const res = await this.callApi('post', 'app/edit-tag', this.editData);
            if (res.status === 200) {
                this.tags[this.index].tag_name = this.editData.tagName;
                this.s('Tag has been edited successfully!');
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    if (res.data.errors.tagName) {
                        this.e(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }

            }
        },
        async deleteTag() {
            this.isDeleting = true;
            const res = await this.callApi('post', 'app/delete-tag', this.deleteItem);
            if (res.status === 200) {
                this.tags.splice(this.deletingIndex, 1);
                this.s('Tag has been deleted successfully!');
            } else {
                this.swr()
            }
            this.isDeleting = false;
            this.deleteModal = false;
        },
        showEditModal(tag, index) {
            let obj = {
                id: tag.id,
                tagName: tag.tag_name,
            }
            this.editData = obj;
            this.editModal = true;
            this.index = index;
        },
        showDeleteModal(tag, i) {
            this.deleteModal = true;
            this.deleteItem = tag;
            this.deletingIndex = i;
        }
    },
    async created() {
        const res = await this.callApi('get', 'app/get-tags')
        if (res.status == 200) {
            this.tags = res.data
        } else {
            this.swr()
        }
    },
};
</script>
<style lang=""></style>
