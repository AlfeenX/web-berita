<x-layouts::app :title="__('Create Article')">

    <div class="max-w-6xl mx-auto space-y-6" x-data="{
        title: '{{ old('title', '') }}',
        slug: '{{ old('slug', '') }}',
        preview: '',
        generateSlug() {
            this.slug = this.title
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        },
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                this.preview = URL.createObjectURL(file);
            }
        }
    }">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Create Article
                </h1>
                <p class="text-slate-400 mt-1">
                    Tulis dan publikasikan artikel baru.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <flux:button variant="ghost" href="{{ route('articles.index') }}">
                    Cancel
                </flux:button>

                <flux:button type="submit" form="article-form" variant="primary" class="bg-indigo-600 hover:bg-indigo-700 text-white">
                    Publish
                </flux:button>
            </div>
        </div>

        <form id="article-form" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Top Inputs --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Left --}}
                <flux:card class="p-6 space-y-5">

                    <div>
                        <h2 class="font-semibold text-lg text-zinc-900 dark:text-white">
                            Article Information
                        </h2>
                        <p class="text-sm text-slate-400">
                            Informasi dasar artikel.
                        </p>
                    </div>

                    {{-- Title --}}
                    <flux:field>
                        <flux:label>
                            Title
                        </flux:label>
                        <flux:input
                            name="title"
                            placeholder="Masukkan judul artikel..."
                            x-model="title"
                            @input="generateSlug"
                            required />
                        <flux:error name="title" />
                    </flux:field>

                    {{-- Slug --}}
                    <flux:field>
                        <flux:label>
                            Slug
                        </flux:label>
                        <flux:input
                            name="slug"
                            placeholder="slug-artikel"
                            x-model="slug"
                            required />
                        <flux:error name="slug" />
                    </flux:field>

                    {{-- Category --}}
                    <flux:field>
                        <flux:label>
                            Category
                        </flux:label>
                        <flux:select name="category_id" placeholder="Choose category" required>
                            @foreach ($categories as $category)
                            <flux:select.option value="{{ $category->id }}" :selected="old('category_id') == $category->id">
                                {{ $category->name }}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="category_id" />
                    </flux:field>

                    <!-- Tag -->
                    <flux:field>
                        <flux:label>Tag</flux:label>

                        <div class="flex flex-wrap gap-2">
                            @foreach ($tags as $tag)
                            <label class="cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="tag_id[]"
                                    value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tag_id', [])) ? 'checked' : '' }}
                                    class="peer hidden">
                                <flux:badge
                                    color="zinc"
                                    class="peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-colors cursor-pointer select-none">
                                    {{ $tag->name }}
                                </flux:badge>
                            </label>
                            @endforeach
                        </div>

                        <flux:error name="tag_id" />
                    </flux:field>
                </flux:card>

                {{-- Right --}}
                <flux:card class="p-6 space-y-5">

                    <div>
                        <h2 class="font-semibold text-lg text-zinc-900 dark:text-white">
                            Thumbnail & Meta
                        </h2>
                        <p class="text-sm text-slate-400">
                            Thumbnail dan informasi tambahan.
                        </p>
                    </div>

                    {{-- Thumbnail --}}
                    <flux:field>
                        <flux:label>
                            Thumbnail
                        </flux:label>

                        <div class="border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-xl p-6 text-center cursor-pointer hover:border-zinc-400 transition"
                            @click="$refs.thumbnail.click()">
                            <template x-if="!preview">
                                <div class="space-y-2">
                                    <flux:icon.photo class="size-8 mx-auto text-zinc-400" />
                                    <div>
                                        <p class="font-medium text-zinc-700 dark:text-zinc-300">
                                            Upload Thumbnail
                                        </p>
                                        <p class="text-sm text-zinc-400">
                                            PNG, JPG, WEBP (Max 2MB)
                                        </p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="preview">
                                <img :src="preview" class="w-full h-52 object-cover rounded-lg">
                            </template>

                            <input type="file" name="image" class="hidden" x-ref="thumbnail" @change="previewImage">
                        </div>

                        <flux:error name="image" />
                    </flux:field>

                </flux:card>

            </div>

            <flux:card class="p-6 space-y-4">
                <div>
                    <h2 class="font-semibold text-lg text-zinc-900 dark:text-white">
                        Content
                    </h2>
                    <p class="text-sm text-slate-400">
                        Isi artikel Anda menggunakan editor teks di bawah ini.
                    </p>
                </div>

                <flux:field>
                    <x-rich-text-editor name="content" :value="old('content', '')" placeholder="Tulis sesuatu yang hebat di sini..." />
                    <flux:error name="content" />
                </flux:field>
            </flux:card>

        </form>

    </div>
</x-layouts::app>