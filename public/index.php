<form id="suggest-form" method="post" action="process-suggestion.php" class="suggest-form">
    <div class="field-row">
        <label>
            Institution name
            <input type="text" name="institution" placeholder="Enter institution name" required>
        </label>
        <label>
            Location
            <input type="text" name="location" placeholder="Chandigarh, Mohali, Panchkula" required>
        </label>
    </div>

    <label>
        Details
        <textarea name="details" rows="4" placeholder="Share the type of institution, courses, or other useful details"></textarea>
    </label>

    <button type="submit" class="primary-btn">Submit suggestion</button>
</form>