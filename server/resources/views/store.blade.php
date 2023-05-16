
<style>
    /* Style the form here */
    label {
      display: block;
      margin-bottom: 10px;
    }
    
    input[type="text"],
    select {
      display: block;
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 15px;
    }
    
    input[type="file"] {
      margin-bottom: 15px;
    }
    
    .description {
      display: flex;
      margin-bottom: 15px;
    }
    
    .description input[type="text"] {
      flex: 1;
      margin-right: 10px;
    }
    
    .description input[type="file"] {
      flex: 1;
    }
    
    button[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    
    button[type="submit"]:hover {
      background-color: #3e8e41;
    }
</style>  
<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>

    <div>
        <label for="heading_image">Heading Image:</label>
        <input type="file" id="heading_image" name="heading_image" required>
    </div>

    <div>
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            {{-- @foreach ($categories as $category) --}}
                {{-- <option value="{{ $category->id }}">{{ $category->name }}</option> --}}
                <option value="7">fotball</option>
            {{-- @endforeach --}}
        </select>
    </div>

    <div>
        <label>Descriptions:</label>
        <div id="descriptions-container">
            <div class="description">
                <input type="text" name="descriptions[0][description]" placeholder="Description" required>
                <input type="file" name="descriptions[0][image]">
            </div>
        </div>
        <button type="button" id="add-description">Add Description</button>
    </div>

    <button type="submit">Create Post</button>
</form>

<script>
    const addDescriptionButton = document.querySelector('#add-description');
    const descriptionsContainer = document.querySelector('#descriptions-container');

    let descriptionCount = 1;

    addDescriptionButton.addEventListener('click', () => {
        const description = document.createElement('div');
        description.classList.add('description');

        const descriptionInput = document.createElement('input');
        descriptionInput.type = 'text';
        descriptionInput.name = `descriptions[${descriptionCount}][description]`;
        descriptionInput.placeholder = 'Description';
        descriptionInput.required = true;

        const imageInput = document.createElement('input');
        imageInput.type = 'file';
        imageInput.name = `descriptions[${descriptionCount}][image]`;

        description.appendChild(descriptionInput);
        description.appendChild(imageInput);
        descriptionsContainer.appendChild(description);

        descriptionCount++;
    });
</script>
