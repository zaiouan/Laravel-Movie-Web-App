<div >
    @if(!$this->liked)
        <button class="block  text-gray-500  hover:text-gray-100  border-gray-900 " wire:click="like" type="submit"><i class="far fa-heart "></i></button>
    @else
        <button wire:click="dislike" type="submit" type><i class="fas fa-heart "></i></button>
    @endif
</div>
