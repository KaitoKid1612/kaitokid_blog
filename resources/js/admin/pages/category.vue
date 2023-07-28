<template lang="">
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Category <Button @click.prevent="addModal=true"><Icon type="md-add" /> Add Category</Button></p>
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
                title="Add category"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="data.tagName" placeholder="Add category name" class="_mar_b10"/>
                <Upload
                    ref="upload"
                    type="drag"
                    :headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest'}"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :format="['jpg','jpeg','png']"
                    :max-size="2048"
                    :on-format-error="handleFormatError"
                    :on-exceeded-size="handleMaxSize"
                    action="/app/upload">
                    <div style="padding: 20px 0">
                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                        <p>Click or drag files here to upload</p>
                    </div>
                </Upload>
                <div class="demo-upload-list" v-if="data.iconImage">
                    <img :src="`/uploads/${data.iconImage}`">
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-eye-outline" ></Icon>
                        <Icon type="ios-trash-outline" @click.prevent="deleteImage"></Icon>
                    </div>
                </div>

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
                categoryName: '',
                iconImage: '',
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
            deletingIndex: 1,
            token: ''
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
        async deleteImage() {
            let image = this.data.iconImage;
            this.data.iconImage = '';
            this.$refs.upload.clearFiles();
            const res = await this.callApi('post', 'app/delete-image', { image: image });
            if (res.status !== 200) {
                this.data.iconImage = image;
                this.swr();
            }
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
        },
        handleSuccess(res, file) {
            this.data.iconImage = res
        },
        handleError(res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
            })
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
    },
    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi('get', 'app/get-tags')
        if (res.status == 200) {
            this.tags = res.data
        } else {
            this.swr()
        }
    },
};
</script>
<style lang="">

</style>
