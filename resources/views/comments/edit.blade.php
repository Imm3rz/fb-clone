<x-app-layout>
    

    <div class="py-8 max-w-xl mx-auto">
        <div class=" p-6 rounded shadow" style="background-color: #252728 !important;">
            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <textarea name="comment" class="w-full border rounded p-2 text-white" style="background-color: #3B3D3E !important;" rows="3" required>{{ old('comment', $comment->comment) }}</textarea>

                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('home') }}" class="text-white px-4 py-2 rounded" style="background-color: #333334 !important" onmouseover="this.style.backgroundColor='#4a4a4a'" onmouseout="this.style.backgroundColor='#333334'">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
