<!-- Agency Rate Us -->
    <div class="modal fade" id="agencyRate" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document" style="margin-top: 3%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Review Us!</h4>
            <p class="bordered-desc">Your Honest answers really help other customers</p>

            <form id="reviewForm" enctype="multipart/form-data">
              {{csrf_field() }}
              <input type="hidden" name="tradesman_id" id="agency_id" value="1">
              <div class="rating-stars">
                <p class="rating-label">Communication</p>
                <div class="stars">
                  <input type="radio" name="communication" id="agency-1-0" value="5" /><label for="agency-1-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="communication" id="agency-1-1" value="4" /><label for="agency-1-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="communication" id="agency-1-2" value="3" /><label for="agency-1-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="communication" id="agency-1-3" value="2" /><label for="agency-1-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="communication" id="agency-1-4"  value="1" /><label for="agency-1-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars">
                <p class="rating-label">Work Quality</p>
                <div class="stars">
                  <input type="radio" name="work-quality" id="agency-2-0" value="5" /><label for="agency-2-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="work-quality" id="agency-2-1" value="4" /><label for="agency-2-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="work-quality" id="agency-2-2" value="3" /><label for="agency-2-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="work-quality" id="agency-2-3" value="2" /><label for="agency-2-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="work-quality" id="agency-2-4"  value="1" /><label for="agency-2-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars">
                <p class="rating-label">Price</p>
                <div class="stars">
                  <input type="radio" name="price" id="agency-3-0" value="5" /><label for="agency-3-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="price" id="agency-3-1" value="4" /><label for="agency-3-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="price" id="agency-3-2" value="3" /><label for="agency-3-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="price" id="agency-3-3" value="2" /><label for="agency-3-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="price" id="agency-3-4"  value="1" /><label for="agency-3-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars">
                <p class="rating-label">Punctuality</p>
                <div class="stars">
                  <input type="radio" name="punctuality" id="agency-4-0" value="5" /><label for="agency-4-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="punctuality" id="agency-4-1" value="4" /><label for="agency-4-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="punctuality" id="agency-4-2" value="3" /><label for="agency-4-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="punctuality" id="agency-4-3" value="2" /><label for="agency-4-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="punctuality" id="agency-4-4"  value="1" /><label for="agency-4-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars no-border">
                <p class="rating-label">Attitude</p>
                <div class="stars">
                  <input type="radio" name="attitude" id="agency-5-0" value="5" /><label for="agency-5-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="attitude" id="agency-5-1" value="4" /><label for="agency-5-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="attitude" id="agency-5-2" value="3" /><label for="agency-5-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="attitude" id="agency-5-3" value="2" /><label for="agency-5-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="attitude" id="agency-5-4"  value="1" /><label for="agency-5-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              </br></br></br>
              <input type="text" name="review-title" placeholder="Enter Review Title">
              <textarea placeholder="Write your review.." name="review-text" class="no-top"></textarea>
              <div class="review-tips">
                <p class="tooltip-info" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tips for writing a great review </br> </br> <b>DO</b> </br> - Describe your overall experience</br> - Tell us if you would recommended the business to others</br>-Talk about the strengths and weaknesses of the experience </br></br> <b>DON'T</b></br>-Lie. Be as honest as possible</br>-Use bad language or personal insults</br>-Be racist, sexist or vulgar" data-html="true">Tips for writing a good review</p>
               </br></br>
              </div>
              <button class="btn hs-primary">Submit Reviews</button>
            </form>
          </div>
        </div>
      </div>
    </div>