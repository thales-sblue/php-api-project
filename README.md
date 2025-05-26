# API de Gerenciamento de Tarefas

## 🚀 Como rodar o projeto

1. Clone este repositório.
2. Execute `docker-compose up --build`.
3. Acesse `http://localhost:8000` e veja a mensagem "API está rodando!".

## 📦 Banco de Dados

- Banco: PostgreSQL
- User: postgres
- Password: postgres
- DB: tarefasdb

O script para criação das tabelas está em `/sql/init.sql`.

---

DocumentRoot está configurado para `/public`, então todos os endpoints da API começam a partir daí.
