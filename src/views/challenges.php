<?php
$networkingChallenges = [
  ['title' => 'Virus', 'points' => 100],
  ['title' => 'Plaintext Palooza', 'points' => 200],
  ['title' => 'Secret Document', 'points' => 300]
];

$cryptoChallenges = [
  ['title' => 'Mono Shift', 'points' => 50],
  ['title' => 'Exclusor', 'points' => 100],
  ['title' => 'Sub Out', 'points' => 150],
  ['title' => 'Weak Primes', 'points' => 300],
  ['title' => 'Many Time Pad', 'points' => 400]
];
?>

<main class="flex-grow-1">

  <!-- Hero / Jumbotron -->
  <section class="py-5 text-center bg-dark text-white border-bottom border-secondary">
    <div class="container">
      <h1 class="display-4 fw-bold">Challenges</h1>
    </div>
  </section>

  <!-- Networking Category -->
  <section class="py-5">
    <div class="container" style="max-width: 1100px;">
      <h2 class="text-white mb-4">Networking</h2>
      <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
        <?php foreach ($networkingChallenges as $challenge): ?>
          <div class="col">
            <button type="button" class="btn p-0 w-100"
              data-bs-toggle="modal"
              data-bs-target="#challengeModal"
              data-title="<?= $challenge['title'] ?>"
              data-points="<?= $challenge['points'] ?>"
              data-description="<?= ($challenge['title'] === 'Secret Document') ? 'We subpoenaed the internet traffic of a John Doe. Can you find out what he&apos;s been up to?' : '' ?>"
              data-file="<?= ($challenge['title'] === 'Secret Document') ? 'secret_document.pcap' : '' ?>"
              data-slug="<?= strtolower(str_replace(' ', '-', $challenge['title'])) ?>">
              <div class="card bg-primary text-light text-center h-100 p-2" style="font-size: 0.9rem;">
                <div class="card-body d-flex flex-column justify-content-between p-3">
                  <div>
                    <h6 class="card-title mb-2"><?= $challenge['title'] ?></h6>
                  </div>
                  <div class="mt-auto"><span class="fw-bold"><?= $challenge['points'] ?></span></div>
                </div>
              </div>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Cryptography Category -->
  <section class="py-5">
    <div class="container" style="max-width: 1100px;">
      <h2 class="text-white mb-4">Cryptography</h2>
      <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
        <?php foreach ($cryptoChallenges as $challenge): ?>
          <div class="col">
            <button type="button" class="btn p-0 w-100"
              data-bs-toggle="modal"
              data-bs-target="#challengeModal"
              data-title="<?= $challenge['title'] ?>"
              data-points="<?= $challenge['points'] ?>"
              data-description=""
              data-file=""
              data-slug="<?= strtolower(str_replace(' ', '-', $challenge['title'])) ?>">
              <div class="card bg-primary text-light text-center h-100 p-2" style="font-size: 0.9rem;">
                <div class="card-body d-flex flex-column justify-content-between p-3">
                  <div>
                    <h6 class="card-title mb-2"><?= $challenge['title'] ?></h6>
                  </div>
                  <div class="mt-auto"><span class="fw-bold"><?= $challenge['points'] ?></span></div>
                </div>
              </div>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Challenge Modal -->
  <div class="modal fade" id="challengeModal" tabindex="-1" aria-labelledby="challengeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="challengeModalLabel">Challenge Title</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-2">Points: <span id="challengePoints">0</span></p>
          <p id="challengeDescription">Description goes here.</p>

          <div id="challengeDownload" class="mb-3 d-none">
            <a id="downloadLink" href="#" class="btn btn-outline-light btn-sm" download>
              <i class="bi bi-download"></i> <span id="downloadFileName">file.pcap</span>
            </a>
          </div>

          <form id="flagForm" class="d-flex align-items-start gap-2">
            <input type="text" class="form-control" id="flagInput" placeholder="Enter flag" required>
            <button type="submit" class="btn btn-light">Submit</button>
          </form>

          <div id="submissionResult" class="mt-2"></div>
        </div>
      </div>
    </div>
  </div>

</main>

<script>
  const challengeModal = document.getElementById('challengeModal');
  const modalTitle = challengeModal.querySelector('.modal-title');
  const modalPoints = challengeModal.querySelector('#challengePoints');
  const modalDescription = challengeModal.querySelector('#challengeDescription');
  const downloadSection = challengeModal.querySelector('#challengeDownload');
  const downloadLink = challengeModal.querySelector('#downloadLink');
  const downloadFileName = challengeModal.querySelector('#downloadFileName');
  const flagForm = challengeModal.querySelector('#flagForm');
  const flagInput = challengeModal.querySelector('#flagInput');
  const resultDiv = challengeModal.querySelector('#submissionResult');

  let currentSlug = '';

  challengeModal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;

    const title = button.getAttribute('data-title');
    const points = button.getAttribute('data-points');
    const description = button.getAttribute('data-description') || 'No description available.';
    const file = button.getAttribute('data-file');
    currentSlug = button.getAttribute('data-slug');

    modalTitle.textContent = title;
    modalPoints.textContent = points;
    modalDescription.textContent = description;
    flagInput.value = '';
    resultDiv.innerHTML = '';

    if (file) {
      downloadSection.classList.remove('d-none');
      downloadFileName.textContent = file;
      downloadLink.href = `/downloads/${file}`;
    } else {
      downloadSection.classList.add('d-none');
    }
  });

  flagForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const submittedFlag = flagInput.value.trim();

    let message = '';
    let className = '';

    if (currentSlug === 'secret-document') {
      if (submittedFlag === 'flag{what_happens_next_will_surprise_you}') {
        message = 'Correct!';
        className = 'text-success';
      } else if (submittedFlag === 'already') {
        message = 'You\'ve already solved this.';
        className = 'text-info';
      } else {
        message = 'Incorrect.';
        className = 'text-danger';
      }
    } else {
      message = 'Incorrect.';
      className = 'text-danger';
    }

    resultDiv.textContent = message;
    resultDiv.className = `mt-2 fw-bold ${className}`;
  });
</script>
