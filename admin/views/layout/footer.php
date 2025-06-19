</main>
<script>
document.addEventListener('DOMContentLoaded',()=>{
  const tit  = document.querySelector('input[name="titulo"]');
  const slug = document.querySelector('input[name="slug"]');
  if(tit && slug){
    tit.addEventListener('keyup',()=>{
      slug.value = tit.value.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g,'')   // quita tildes
        .replace(/[^a-z0-9\s-]/g,'')                      // quita no válidos
        .trim().replace(/\s+/g,'-');                      // espacios→-
    });
  }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
