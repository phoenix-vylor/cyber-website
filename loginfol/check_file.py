import sys
import os

def is_malicious(file_path):
    # This is a placeholder for actual malicious file detection logic
    # For example, you might integrate with VirusTotal API, use a machine learning model, etc.
    # Here, we simply assume that files over 10MB are considered malicious for demonstration purposes
    file_size = os.path.getsize(file_path)
    if file_size > 10000000:  # 10 MB
        return True
    return False

if __name__ == "__main__":
    file_path = sys.argv[1]
    if is_malicious(file_path):
        print("The file is malicious.")
    else:
        print("The file is clean.")
