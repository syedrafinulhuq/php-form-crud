<?php
session_start();

$_SESSION['messages'] ??= [];


if (isset($_GET['clear']) && $_GET['clear'] === '1') {
  $_SESSION['messages'] = [];
  header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'), true, 303);
  session_write_close();
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $msg = htmlspecialchars(trim($_POST['customer_message'] ?? ''), ENT_QUOTES, 'UTF-8');
  if ($msg !== '') array_unshift($_SESSION['messages'], $msg);

  header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'), true, 303);
  session_write_close();
  exit;
}

$messages = $_SESSION['messages'];
session_write_close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  
  <style>
    :root { --ui: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
  </style>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { ui: ['var(--ui)'] },
        },
      },
    };
  </script>

  <title>PHP Form</title>
</head>
<body class="font-ui bg-gray-100 p-6 dark:bg-slate-900">
  <div class="mx-auto max-w-sm">
    <!-- Header card -->
    <div class="flex items-center gap-x-4 rounded-xl bg-white p-6 shadow-lg outline outline-black/5 dark:bg-slate-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
      <img class="size-12 shrink-0 rounded-full" src="/img.png" alt="ChitChat Logo" width="48" height="48" />
      <div>
        <div class="text-xl font-medium text-black dark:text-white">ChitChat</div>
        <p class="text-gray-600 dark:text-gray-400">You have a new message!</p>


        <?php if (!empty($messages)) : ?>
          <div class="mt-4 rounded-lg border border-green-300 bg-green-100 p-4 dark:border-green-700 dark:bg-green-900/30">
            <h2 class="text-lg font-semibold text-green-800 dark:text-green-300">New Message:</h2>
            <p class="mt-1 text-black dark:text-white"><?php echo $messages[0]; ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if (!empty($messages)) : ?>
      <div class="mt-6 rounded-xl bg-white p-6 shadow-lg outline outline-black/5 dark:bg-slate-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
        <h3 class="mb-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Previous Messages</h3>
        <ul class="space-y-2">
          <?php foreach ($messages as $i => $m) : ?>
            <li class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 dark:border-slate-700 dark:bg-slate-900 dark:text-gray-100">
              <span class="mr-2 rounded bg-gray-200 px-2 py-0.5 text-xs dark:bg-slate-700"><?php echo $i + 1; ?></span>
              <?php echo $m; ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <a href="?clear=1" class="mt-4 inline-block rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">Clear messages</a>
      </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="" method="POST" class="mt-6 space-y-3 rounded-xl bg-white p-6 shadow-lg outline outline-black/5 dark:bg-slate-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
      <label for="customer_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Enter your message here!
      </label>
      <textarea id="customer_message" name="customer_message" rows="3"
        class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-100"
        placeholder="Type something..."></textarea>
      <button type="submit" class="mt-2 w-full rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
        Send Message
      </button>
    </form>
  </div>
</body>
</html>
