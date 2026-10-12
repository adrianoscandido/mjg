import os
import posixpath
import shutil
import paramiko

HOST = "77.37.127.215"
PORT = 65002
USER = "u683004893"
PASS = "@193945+Lara@"
REMOTE_PATH = "/home/u683004893/domains/mjgimports.com.br/public_html"

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
LOCAL_DIST = os.path.join(BASE_DIR, "dist", "client")
if not os.path.exists(LOCAL_DIST):
    LOCAL_DIST = os.path.join(BASE_DIR, ".output", "public")

BACKEND_DIR = os.path.join(BASE_DIR, "backend")

def sync_backend_to_dist():
    if not os.path.exists(BACKEND_DIR):
        return
    for item in ["admin", "api"]:
        src = os.path.join(BACKEND_DIR, item)
        dst = os.path.join(LOCAL_DIST, item)
        if os.path.exists(src):
            if os.path.exists(dst):
                shutil.rmtree(dst)
            shutil.copytree(src, dst)
            print(f"Sincronizado {item} para pasta pública de produção.")

def sftp_mkdir_p(sftp, remote_directory):
    dirs_to_create = []
    dir_name = remote_directory
    while len(dir_name) > 1:
        try:
            sftp.stat(dir_name)
            break
        except FileNotFoundError:
            dirs_to_create.append(dir_name)
            dir_name = posixpath.dirname(dir_name)
    while len(dirs_to_create) > 0:
        d = dirs_to_create.pop()
        try:
            sftp.mkdir(d)
            sftp.chmod(d, 0o755)
        except Exception:
            pass

def upload_folder(sftp, local_dir, remote_dir):
    print(f"Uploading files from {local_dir} to {remote_dir}...")
    total_files = 0
    for root, dirs, files in os.walk(local_dir):
        rel_dir = os.path.relpath(root, local_dir).replace("\\", "/")
        if rel_dir == ".":
            curr_remote = remote_dir
        else:
            curr_remote = posixpath.join(remote_dir, rel_dir)
            sftp_mkdir_p(sftp, curr_remote)

        for file in files:
            local_file = os.path.join(root, file)
            remote_file = posixpath.join(curr_remote, file)
            print(f"  -> {file} to {remote_file}")
            sftp.put(local_file, remote_file)
            sftp.chmod(remote_file, 0o644)
            total_files += 1

    print(f"Upload completed! Total files: {total_files}")

def main():
    sync_backend_to_dist()

    if not os.path.exists(LOCAL_DIST):
        print(f"Error: {LOCAL_DIST} does not exist. Run 'npm run build' first.")
        return

    print(f"Connecting to {HOST}:{PORT} via SSH...")
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(HOST, port=PORT, username=USER, password=PASS, timeout=15)

    sftp = ssh.open_sftp()

    # Rename default.php if present
    default_php = posixpath.join(REMOTE_PATH, "default.php")
    try:
        sftp.stat(default_php)
        bak_php = posixpath.join(REMOTE_PATH, "default.php.bak")
        print(f"Renaming {default_php} to {bak_php}...")
        try:
            sftp.remove(bak_php)
        except Exception:
            pass
        sftp.rename(default_php, bak_php)
    except FileNotFoundError:
        pass

    upload_folder(sftp, LOCAL_DIST, REMOTE_PATH)

    sftp.close()
    ssh.close()
    print("\nDeploy finalizado com sucesso! Acesse:")
    print("Site: https://mjgimports.com.br")
    print("Painel: https://mjgimports.com.br/admin/login.php")

if __name__ == "__main__":
    main()
